<?php

namespace App\Nova\Metrics;

use App\Models\Product;
use App\Models\OrderItem;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class LeastSoldProducts extends Partition
{
    /**
     * @var string
     */
    public $name = 'Ən Az Satılan Məhsullar';

    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        $salesData = OrderItem::query()
            ->selectRaw('product_id, COUNT(*) as total_sales')
            ->groupBy('product_id')
            ->orderBy('total_sales')
            ->limit(10)
            ->get();

        $formattedData = [];
        foreach ($salesData as $data) {
            $productName = Product::query()->find($data->product_id)->name ?? 'Unknown';
            $formattedData[$productName] = $data->total_sales;
        }
        return $this->result($formattedData);
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
        return 'least-selling-products';
    }
}
