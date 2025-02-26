<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Slider;
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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProducts(Request $request)
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

//        Product::factory(1000)->create();
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
}
