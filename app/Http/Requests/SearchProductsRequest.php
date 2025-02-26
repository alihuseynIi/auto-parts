<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => ["required", "int", "exists:users,id"],
            "product_type" => ["nullable"],
            "brand" => ["nullable"],
            "product_category" => ["nullable"],
            "car_brand" => ["nullable"],
            "car_model" => ["nullable"],
            "query" => ["nullable"],
            "campaign" => ["bool"],
            "new_product" => ["bool"],
            "availability" => ["bool"],
            "page" => ["nullable", "int", "min:1"],
            "limit" => ["nullable", "int", "min:1"],
        ];
    }
}
