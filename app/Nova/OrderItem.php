<?php
namespace App\Nova;

use App\Nova\Actions\UpdateOrderItemStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
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
     * @var int[]
     */
    public static $perPageOptions = [10];

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

//            Text::make('OEM No', 'oem_code')
//                ->readonly()
//                ->sortable(),

            BelongsTo::make('Sifariş', 'order', Order::class)
                ->readonly()
                ->sortable(),

            BelongsTo::make('Məhsul', 'product', Product::class)
                ->readonly()
                ->sortable(),

//            Text::make('Məhsul Adı', 'product_name')
//                ->sortable(),

            Number::make('Qiyməti', 'product_price')
                ->displayUsing(fn($value) => number_format($value, 2).' ₼')
                ->readonly()
                ->sortable(),

            Number::make('Miqdar', 'quantity')
                ->readonly()
                ->sortable(),

            Number::make('Ümumi Qiymət', 'total_price')
                ->displayUsing(fn($value) => number_format($value, 2).' ₼')
                ->readonly()
                ->sortable(),

            Select::make('Status', 'status')
                ->options([
                    'pending' => 'Gözləmədə',
                    'accepted' => 'Qəbul edildi',
                    'completed' => 'Tamamlandı',
                    'canceled' => 'Ləğv edildi',
                ])
                ->displayUsingLabels()
                ->sortable()
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
    public static function authorizedToCreate(Request $request): false
    {
        return false;
    }

    /**
     * @param Request $request
     * @return UpdateOrderItemStatus[]
     */
    public function actions(Request $request): array
    {
        return [
            new UpdateOrderItemStatus()
        ];
    }
}
