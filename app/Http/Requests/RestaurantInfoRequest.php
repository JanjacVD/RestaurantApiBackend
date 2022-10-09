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
            'sentLang' => ['required', 'array'],
            'sentLang*' => ['string'],
            'day_from' => ['required', 'integer'],
            'day_to' => ['required', 'integer'],
            'time_from' => ['required', 'string'],
            'time_to' => ['required', 'string'],
            'is_open' => ['required', 'boolean'],
            'about_us_title' => ['required'],
            'about_us_text' => ['required'],
            'icon_translations' => ['required'],
        ];
    }
}
