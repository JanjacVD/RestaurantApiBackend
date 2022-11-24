<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'day_from' => ['required', 'integer'],
            'day_to' => ['required', 'integer'],
            'time_from' => ['required', 'string'],
            'time_to' => ['required', 'string'],
            'bookable_from' => ['required', 'string'],
            'bookable_to' => ['required', 'string'],
            'is_open' => ['required', 'boolean'],
            'reservations_open' => ['required', 'boolean']
        ];
    }
}
