<?php

namespace App\Nova\Lenses;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\DB;

class LeastSellingProductsLens extends Lens
{
    /**
     * @param NovaRequest $request
     * @param $query
     * @return Paginator|Builder
     */
    public static function query(NovaRequest $request, $query): Paginator|Builder
    {
        return $query
            ->select('products.id', 'products.name', DB::raw('COUNT(order_items.id) as total_sold'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'asc');
    }

    /**
     * @param NovaRequest $request
     * @return array|Field[]
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Məhsul Adı', 'name')->sortable(),
            Number::make('Satış Sayı', 'total_sold')->sortable(),
        ];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Ən Az Satılan Məhsullar';
    }
}
