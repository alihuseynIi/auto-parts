<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class CategoriesResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->collection
            ->groupBy('parent')
            ->map(function ($group) {
                $allOption = new Category(['id' => "all", 'name' => 'Hamısı']);
                $group->prepend($allOption);

                return GetCategoriesResource::collection($group);
            })
            ->toArray();
    }
}
