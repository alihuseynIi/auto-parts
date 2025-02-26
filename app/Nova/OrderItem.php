<?php
namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderItem extends Resource
{
    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Sifariş Məhsullar';
    }

    /**
     * @var string
     */
    public static $model = \App\Models\OrderItem::class;

    /**
     * @var string
     */
    public static $title = 'product_name';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'product_name',
    ];

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('OEM No', 'oem_code')
                ->sortable(),

            BelongsTo::make('Sifariş', 'order', Order::class)
            ->sortable(),

            BelongsTo::make('Məhsul', 'product', Product::class)
            ->sortable(),

            Text::make('Məhsul Adı', 'product_name')
                ->sortable(),

            Number::make('Məhsul Qiyməti', 'product_price')
                ->sortable(),

            Number::make('Miqdar', 'quantity')
                ->sortable(),

            Number::make('Ümumi Qiymət', 'total_price')
                ->sortable(),
        ];
    }

    /**
     * @param Request $request
     * @return false
     */
    public function authorizedToReplicate(Request $request): false
    {
        return false;
    }

    /**
     * @param Request $request
     * @return false
     */
    public function authorizedToUpdate(Request $request): false
    {
        return false;
    }

    /**
     * @param Request $request
     * @return false
     */
    public function authorizedToDelete(Request $request): false
    {
        return false;
    }

    /**
     * @param Request $request
     * @return false
     */
    public function authorizedToView(Request $request): false
    {
        return false;
    }

    /**
     * @param Request $request
     * @return false
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }
}
