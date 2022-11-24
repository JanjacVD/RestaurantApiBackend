<?php

namespace App\Http\Controllers\Guest;

use App\Events\NewReservationConfirmed;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\Menu\FoodSectionResource;
use App\Http\Resources\RestaurantInfoResource;
use App\Jobs\ConfirmedReservationEmail;
use App\Jobs\NewReservationEmail;
use App\Jobs\NotifyAdminForReservation;
use App\Jobs\PendingReservationEmail;
use App\Jobs\SendCanceledReservationMail;
use App\Jobs\SendContactEmail;
use App\Mail\NewReservation;
use App\Models\DisabledDates;
use App\Models\Menu\FoodSection;
use App\Models\Reservation;
use App\Models\RestaurantInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PublicController extends Controller
{
    public function menu()
    {
        $menu = Cache::rememberForever('menu', function () {
            $query = FoodSection::with('foodCategory', 'foodCategory.foodItem', 'foodCategory.foodItem.alergen')->get();
            $data = FoodSectionResource::collection($query);
            return $data;
        });
        return $menu;
    }

    public function contact(ContactRequest $request)
    {
        $email = $request->email;
        $name = $request->name;
        $subject = $request->subject;
        $msg = $request->text;
        SendContactEmail::dispatch($email, $name, $subject, $msg)->onQueue('low');
        return response()->json(['status' => 'sent'], 200);
    }
    public function workTime()
    {
        $data = RestaurantInfo::first();
        return new RestaurantInfoResource($data);
    }
    public function disabledDates()
    {
        $maxReservationsPerDay = 40;
        $booked = Reservation::bookedDates($maxReservationsPerDay);
        $disabledDates = DisabledDates::all()->pluck('date')->toArray();
        $dates = array_merge($booked, $disabledDates);
        return response()->json(['dates' => $dates], 200);
        // $booked = Reservation::selectRaw('CAST(reservation_datetime as DATE) as date')
        //     ->groupBy('date')
        //     ->havingRaw('count(date) >= ?', [$maxReservationsPerDay])->pluck('date')->toArray();
    }
    public function disabledTimes(Request $request)
    {
        $maxReservationsPerTimePeriod = 5;
        $booked = Reservation::bookedTimes($request->date, $maxReservationsPerTimePeriod);
        return response()->json(['times' => $booked], 200);

        // $booked = Reservation::whereDate('reservation_datetime', $request->date)
        //     ->groupBy('reservation_datetime')
        //     ->havingRaw('count(*) >= ?',[$maxReservationsPerTimePeriod])->pluck('reservation_datetime')->toArray();
    }
    public function reservationMake(ReservationRequest $request)
    {
        $info = RestaurantInfo::first();
        $minTime = $info->bookable_from;
        $maxTime = $info->bookable_to;
        $maxFoward = 40;
        $minFoward = 1;
        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDays($maxFoward), 'Europe/Zagreb');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDays($minFoward), 'Europe/Zagreb');
        $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($request->reservation_datetime), 'Europe/Zagreb');

        $s = $dateTime->format('Y-m-d');
        $start = Carbon::parse($s . $minTime)->format('Y-m-d H:i');
        $end = Carbon::parse($s . $maxTime)->format('Y-m-d H:i');
        $date = $dateTime->format('Y-m-d');
        if (!$dateTime->between($start, $end)) {
            abort(400, 'Invalid time');
        };
        $booked = Reservation::bookedTimes($date, 5);
        if (($dateTime >= $minDate) && ($dateTime <= $maxDate) && !in_array($dateTime, $booked)) {
            try {
                $uuid = Str::uuid();
                $res = Reservation::create([
                    'uuid' => $uuid,
                    'name' => $request->name,
                    'numOfPeople' => $request->numOfPeople,
                    'reservation_datetime' => $request->reservation_datetime,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'confirmed' => false
                ]);
                PendingReservationEmail::dispatch($res)->onQueue('high');
            } catch (Throwable $e) {
                Log::info($e);
                return response()->json(['status' => 'Error happened'], 500);
            }
        } else {
            abort(403, 'Invalid date');
        }
    }
    public function reservationConfirm(Request $request)
    {
        $user = Reservation::where('uuid', $request->uuid)->firstOrFail();
        if ($user->confirmed) {
            return response()->json(['status' => 'Already confirmed'], 200);
        } else {
            $user->confirmed = true;
            $user->save();
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qr_image = base64_encode($writer->writeString($user->uuid));
            ConfirmedReservationEmail::dispatch($user, $qr_image)->onQueue('default');
            NotifyAdminForReservation::dispatch($user)->onQueue('high');
            return response()->json(['status' => 'confirmed'], 200);
        }
    }
    public function reservationCancel(Request $request){
        $user = Reservation::where('uuid', $request->uuid)->firstOrFail();
        $name= $user->name;
        $time = $user->reservation_datetime;
        SendCanceledReservationMail::dispatch($name, $time)->onQueue('high');
        $user->delete();
        return response()->noContent();
    }
}
