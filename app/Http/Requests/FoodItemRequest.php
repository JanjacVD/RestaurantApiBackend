<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemRequest extends FormRequest
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
            'title' => ['required'],
            'description' => ['required'],
            'alergen' => ['array', 'nullable'],
            'price' => ['required', 'numeric'],
            'food_category' => ['required', 'integer']
        ];
    }
}
