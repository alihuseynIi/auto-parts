<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $discountedPrice = $this["product"]["discounted_price"] ?? $this["product"]["price"];

        $totalPrice = $this["quantity"] * $this["product"]["price"];
        $totalDiscount = ($this["product"]["price"] - $discountedPrice) * $this["quantity"];
        $totalAmount = $this["quantity"] * $discountedPrice;

        return [
            "id" => $this["id"],
            "product_id" => $this["product_id"],
            "stock" => $this["product"]["stock"],
            "quantity" => $this["quantity"],
            "name" => $this["product"]["name"],
            "price" => $this["product"]["price"],
            "discounted_price" => $discountedPrice,
            "total_price" => $totalPrice,
            "total_discount" => $totalDiscount,
            "total_amount" => $totalAmount,
        ];
    }
}
