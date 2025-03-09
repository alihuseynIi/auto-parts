<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            "address_id" => ["required", "int", "exists:user_addresses,id"],
            "date" => ["required", "int", Rule::in([1,2])],
            "total_price" => ["required", "numeric"],
            "products" => ["required", "array"],
            "products.*.product_id" => ["required", "int", "exists:products,id"],
            "products.*.quantity" => ["required", "int", "min:1"],
            "products.*.total_amount" => ["required", "numeric"],
        ];
    }
}
