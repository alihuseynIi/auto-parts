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

class TopSearchQueriesLens extends Lens
{
    /**
     * @param NovaRequest $request
     * @param $query
     * @return Paginator|Builder
     */
    public static function query(NovaRequest $request, $query): Paginator|Builder
    {
        return $query
            ->select('query', DB::raw('SUM(count) as total_searches'))
            ->from('search_logs')
            ->groupBy('query')
            ->orderByDesc('total_searches');
    }

    /**
     * @param NovaRequest $request
     * @return array|Field[]
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Axtarış Sözü', 'query')->sortable(),
            Number::make('Axtarış Sayı', 'total_searches')->sortable(),
        ];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Ən Çox Axtarılan Sözlər';
    }
}
