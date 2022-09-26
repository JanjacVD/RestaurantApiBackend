<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\Menu\FoodSectionResource;
use App\Jobs\SendContactEmail;
use App\Models\Menu\FoodSection;
use Illuminate\Support\Facades\Cache;

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
}
