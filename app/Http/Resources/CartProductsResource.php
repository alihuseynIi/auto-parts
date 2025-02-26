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
        return [
            "id" => $this["id"],
            "product_id" => $this["product_id"],
            "quantity" => $this["quantity"],
            "name" => $this["product"]["name"],
            "price" => $this["product"]["price"],
        ];
    }
}
