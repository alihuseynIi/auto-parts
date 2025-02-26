<?php

namespace App\Nova\Metrics;

use App\Models\OrderItem;
use App\Models\Product;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class TopSellingProducts extends Partition
{
    /**
     * @var string
     */
    public $name = 'Ən Çox Satılan Məhsullar';

    /**
     * @param NovaRequest $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, OrderItem::class, 'product_id')
            ->label(function ($value) {
                return optional(Product::query()->find($value))->name ?? 'Unknown';
            });
    }

    /**
     * @return DateTimeInterface|null
     */
    public function cacheFor(): DateTimeInterface|null
    {
         return now()->addMinutes(10);
    }

    /**
     * @return string
     */
    public function uriKey(): string
    {
        return 'top-selling-products';
    }
}
