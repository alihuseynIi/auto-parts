<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Slider;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FetchService
{
    /**
     * @param int|null $category_id
     * @return Collection
     */
    public function getCategories(?int $category_id): Collection
    {
        if ($category_id) {
            return Category::query()
                ->where("brand_id", $category_id)
                ->orderBy("name")
                ->get();
        } else {
            return Category::query()->whereIn("parent", [
                "product_type",
                "brand",
                "product_category",
                "car_brand"
            ])->orderBy("name")
                ->get();
        }
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function searchProducts(Request $request): LengthAwarePaginator
    {
        $productType = (int)$request->input("product_type");
        $brand = (int)$request->input("brand");
        $productCategory = (int)$request->input("product_category");
        $carBrand = (int)$request->input("car_brand");
        $carModel = (int)$request->input("car_model");
        $campaign = $request->input("campaign");
        $newProduct = $request->input("new_product");
        $availability = $request->input("availability");
        $queryTerm = $request->input("query");
        $queryTerm = str_replace([' ', '-'], '', $queryTerm);

        $query = Product::query();

        if ($productType) {
            $query->where("product_type", $productType);
        }
        if ($brand) {
            $query->where("brand", $brand);
        }
        if ($productCategory) {
            $query->where("product_category", $productCategory);
        }
        if ($carBrand) {
            $query->where("car_brand", $carBrand);
        }
        if ($carModel) {
            $query->where("car_model", $carModel);
        }
        if ($campaign) {
            $query->where("campaign", $campaign);
        }
        if ($newProduct) {
            $query->where("new_product", $newProduct);
        }
        if ($availability) {
            $query->where("stock", ">", 0);
        }

        if ($queryTerm) {
            $query->where(function($subQuery) use ($queryTerm) {
                $subQuery->whereRaw("REPLACE(REPLACE(code, ' ', ''), '-', '') LIKE ?", ['%' . $queryTerm . '%'])
                    ->orWhereRaw("REPLACE(REPLACE(oem_code, ' ', ''), '-', '') LIKE ?", ['%' . $queryTerm . '%'])
                    ->orWhereRaw("REPLACE(REPLACE(name, ' ', ''), '-', '') LIKE ?", ['%' . $queryTerm . '%']);
            });

            $searchLog = SearchLog::query()->where("query", $queryTerm);

            if ($searchLog->exists()) {
                $searchLog->increment("count");
            } else {
                $searchLog->create([
                    "user_id" => $request->input("user_id"),
                    "query" => $queryTerm,
                ]);
            }

        }

//        Product::factory(100)->create();
        $result = $query->paginate(
            perPage: $request->input("limit", 10),
            page: $request->input("page", 1)
        );

        $brandIds = $result->pluck('brand')->unique()->filter()->values();
        $carBrandIds = $result->pluck('car_brand')->unique()->filter()->values();
        $carModelIds = $result->pluck('car_model')->unique()->filter()->values();

        $allCategoryIds = $brandIds->merge($carBrandIds)->merge($carModelIds)->unique();
        $categories = Category::query()->whereIn('id', $allCategoryIds)->get()->keyBy('id');

        $updatedItems = $result->getCollection()->map(function ($item) use ($categories) {
            $item->brand = $categories[$item->brand]->name ?? '-';
            $item->car_brand = $categories[$item->car_brand]->name ?? '-';
            $item->car_model = $categories[$item->car_model]->name ?? '-';
            return $item;
        });

        return $result->setCollection($updatedItems);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSliders(): \Illuminate\Support\Collection
    {
        return Slider::query()->pluck("image");
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getBrandSliders(): \Illuminate\Support\Collection
    {
        return Brand::query()->pluck("image");
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getOrders(Request $request): mixed
    {
        $orderItemsPaginated = OrderItem::query()
            ->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->input('user_id'));
            })
            ->with('order')
            ->orderByDesc(
                Order::query()->select('created_at')
                    ->whereColumn('orders.id', 'order_items.order_id')
            );

        if($request->input("limit")) {
                $orderItemsPaginated = $orderItemsPaginated->paginate(
                    perPage: $request->input("limit", 10),
                    page: $request->input("page", 1)
                );
            } else {
                $orderItemsPaginated = $orderItemsPaginated->get();
            }

        $formattedOrderItems = $orderItemsPaginated->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product_name,
                'product_price' => $item->product_price,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
                'status' => $item->status,
                'created_at' => $item->order->created_at->format('d-m-Y'),
            ];
        });

            $response = [];
            if ($request->input("limit")) {
                $response["current_page"] = $orderItemsPaginated->currentPage();
                $response["last_page"] = $orderItemsPaginated->lastPage();
                $response["per_page"] = $orderItemsPaginated->perPage();
                $response["total"] = $orderItemsPaginated->total();
            }

            $response['order_items'] = $formattedOrderItems;

        return $response;
    }
}
