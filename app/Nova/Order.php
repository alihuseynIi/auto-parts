<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Order extends Resource
{
    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Sifarişlər';
    }

    /**
     * @var string
     */
    public static string $model = \App\Models\Order::class;

    /**
     * @var string
     */
    public static $title = 'id';

    /**
     * @var string[]
     */
    public static $search = ['id', 'status'];

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('İstifadəçi', 'user', User::class)
                ->readonly()
                ->sortable(),

            Text::make('Adres', 'address')
            ->sortable()
            ->readonly(),

            Number::make('Ümumi Qiymət', 'total_price')
                ->sortable()
                ->readonly(),

            Text::make('Çatdırılma Saatı', 'date')
                ->sortable()
                ->readonly(),

            Select::make('Status', 'status')
                ->options([
                    'pending' => 'Gözləmədə',
                    'accepted' => 'Qəbul edildi',
                    'completed' => 'Tamamlandı',
                    'canceled' => 'Ləğv edildi',
                ])
                ->displayUsingLabels()
                ->sortable(),

            HasMany::make('Sifariş Məhsulları', 'items', OrderItem::class),
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
    public function authorizedToDelete(Request $request): false
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
}
