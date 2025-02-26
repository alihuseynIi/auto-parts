<?php

namespace App\Nova\Metrics;

use App\Models\SearchLog;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class TopSearch extends Partition
{
    /**
     * @var string
     */
    public $name = 'Ən Çox Axtarılan Sözlər';

    /**
     * Calculate the metric.
     *
     * @param NovaRequest $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        $searchData = SearchLog::query()
            ->selectRaw('query, SUM(count) as total')
            ->groupBy('query')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'query');

        return $this->result($searchData->toArray());
    }

    /**
     * Determine how long to cache the metric.
     *
     * @return \DateTimeInterface|null
     */
    public function cacheFor(): \DateTimeInterface|null
    {
        return null;
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'top-search-words';
    }
}
