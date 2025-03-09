<?php

namespace App\Services;

use App\Http\Resources\CartProductsResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CommonService
{
    /**
     * @param Request $request
     * @return array
     */
    public function addToCart(Request $request): array
    {
        $product = Product::query()->find($request->input("product_id"));
        $quantity = $request->input("quantity");

        if ($product->stock < $request->input("quantity")) {
            $quantity = $product->stock;
        }

        CartItem::query()->updateOrCreate(
            ["user_id" => $request->input("user_id"), "product_id" => $request->input("product_id")],
            ["quantity" => $quantity]
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
     * @return array
     */
    public function getCartProducts($user): array
    {
        $cartItems = $user->cartItems()->with('product')->get();
        $cartProductsResource = CartProductsResource::collection($cartItems);

        $filteredCartItems = $cartItems->filter(function ($cartItem) {
            return $cartItem->product->stock > 0;
        });

        $totalPrice = $filteredCartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $totalDiscount = $filteredCartItems->sum(function ($cartItem) {
            $discountedPrice = $cartItem->product->discounted_price ?? $cartItem->product->price;
            return ($cartItem->product->price - $discountedPrice) * $cartItem->quantity;
        });

        $totalAmount = $totalPrice - $totalDiscount;

        return [
            'cart_products' => $cartProductsResource,
            'total_price' => $totalPrice,
            'discount' => $totalDiscount,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function order(Request $request): array
    {
        $products = $request->input("products");
        $productIds = array_column($products, 'product_id');

        $orderedProducts = Product::query()->whereIn("id", $productIds)->get()->keyBy('id');

        foreach ($products as $product) {
            if (empty($orderedProducts[$product['product_id']]) || $product['quantity'] > $orderedProducts[$product['product_id']]->stock) {
                return ["status" => Response::HTTP_CONFLICT, "message" => "Product out of stock"];
            }
        }

        DB::beginTransaction();
        try {
            $order = Order::query()->create([
                "user_id" => $request->input("user_id"),
                "address" => UserAddress::query()->find($request->input("address_id"))->address,
                "date" => $request->input("date") == 1 ? '09:00 - 15:00' : '15:00 - 18:00',
                "total_price" => $request->input("total_price"),
            ]);

            $orderItems = [];
            foreach ($products as $product) {
                $productData = $orderedProducts[$product['product_id']];

                $productData->stock -= $product['quantity'];
                $productData->save();

                $orderItems[] = [
                    "order_id" => $order->id,
                    "oem_code" => $productData->oem_code,
                    "product_id" => $productData->id,
                    "product_name" => $productData->name,
                    "product_price" => $productData->discounted_price ?? $productData->price,
                    "quantity" => $product['quantity'],
                    "total_price" => $product['total_amount']
                ];
            }

            OrderItem::query()->insert($orderItems);
            CartItem::query()->where("user_id", $request->input("user_id"))->delete();

            DB::commit();
            return ["status" => Response::HTTP_CREATED, "message" => "success"];
        } catch (Exception $e) {
            DB::rollBack();
            return ["status" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "Order processing failed"];
        }
    }
}
