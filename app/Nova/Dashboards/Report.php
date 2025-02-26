<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\LeastSoldProducts;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\TopSearch;
use App\Nova\Metrics\TopSellingProducts;
use Laravel\Nova\Dashboard;

class Report extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            (new NewUsers())->width('1/2'),
            (new TopSellingProducts())->width('1/2'),

            (new LeastSoldProducts())->width('1/2'),
            (new TopSearch())->width('1/2'),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     */
    public function uriKey(): string
    {
        return 'report';
    }
}
