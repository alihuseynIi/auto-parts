<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CommonService
{
    /**
     * @param Request $request
     * @return array
     */
    public function addToCart(Request $request): array
    {
        CartItem::query()->updateOrCreate(
            ["user_id" => $request->input("user_id"), "product_id" => $request->input("product_id")],
            ["quantity" => $request->input("quantity")]
        );

        return ["cart_items_count" => CartItem::query()->where('user_id', $request->input("user_id"))->count()];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeFromCart(Request $request): void
    {
        CartItem::query()
            ->where('user_id', $request->input("user_id"))
            ->where('product_id', $request->input("product_id"))
            ->delete();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getCartProducts($user): mixed
    {
        return $user->cartItems()->with('product')->get();
    }
}
