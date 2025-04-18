<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
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
            "product_id" => ["required", "int", "exists:products,id"],
            "quantity" => ["nullable", "int", "min:1", Rule::requiredIf($this->isMethod('POST'))],
        ];
    }
}
