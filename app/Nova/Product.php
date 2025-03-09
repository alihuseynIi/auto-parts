<?php

namespace App\Nova;

use App\Nova\Lenses\LeastSellingProductsLens;
use App\Nova\Lenses\TopSearchQueriesLens;
use App\Nova\Lenses\TopSellingProductsLens;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Məhsullar';
    }

    /**
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * @var int[]
     */
    public static $perPageOptions = [10];

    /**
     * @var string
     */
    public static $title = 'name';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'code', 'oem_code', 'name',
    ];

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Kodu', 'code')
                ->nullable()
                ->sortable(),

            Text::make('OEM No', 'oem_code')
                ->nullable()
                ->sortable(),

            Text::make('Adı', 'name')
                ->rules('required')
                ->sortable(),

            Select::make('Məhsulun növü', 'product_type')
                ->options($this->getCategories('product_type'))
                ->showOnIndex(false)
                ->displayUsing(fn($value) => $this->getCategoryNameById($value)),

            Select::make('Məhsulun kateqoriyası', 'product_category')
                ->options($this->getCategories('product_category'))
                ->showOnIndex(false)
                ->displayUsing(fn($value) => $this->getCategoryNameById($value)),

            Select::make('Brend', 'brand')
                ->options($this->getCategories('brand'))
                ->showOnIndex(false)
                ->displayUsing(fn($value) => $this->getCategoryNameById($value)),

            Select::make('Avtomobilin markası', 'car_brand')
                ->options($this->getCategories('car_brand'))
                ->showOnIndex(false)
                ->displayUsing(fn($value) => $this->getCategoryNameById($value)),

            Select::make('Avtomobilin modeli', 'car_model')
                ->options(fn() => [])
                ->dependsOn(['car_brand'], function (Select $field, NovaRequest $request, FormData $formData) {
                    if ($formData->car_brand) {
                        $field->options($this->getCarModels($formData->car_brand));
                    }
                })
                ->showOnIndex(false)
                ->displayUsing(fn($value) => $this->getCategoryNameById($value)),


            Number::make('Stok sayı', 'stock')
                ->default(1)
                ->min(0)
                ->step(1)
                ->sortable(),

            Number::make('Qiymət', 'price')
                ->rules('required')
                ->displayUsing(fn($value) => number_format($value, 2).' ₼')
                ->sortable(),

            Number::make('Endirimli qiymət', 'discounted_price')
                ->displayUsing(fn($value) => number_format($value, 2).' ₼')
                ->sortable(),

            Image::make('Şəkil', 'image')
                ->disk('public')
                ->path('products')
                ->showOnIndex(false)
                ->nullable(),

            Boolean::make('Aksiya', 'campaign')
                ->showOnIndex(false)
                ->trueValue(true)
                ->falseValue(false)
                ->sortable(),

            Boolean::make('Yeni Məhsul', 'new_product')
                ->showOnIndex(false)
                ->trueValue(true)
                ->falseValue(false)
                ->sortable(),
        ];
    }

    /**
     * @param string $type
     * @return array
     */
    public function getCategories(string $type): array
    {
        $formattedData = [];
        $categories = \App\Models\Category::query()->where('parent', $type)->get()->toArray();

        foreach ($categories as $category) {
            $formattedData[$category['id']] = $category['name'];
        }
        return $formattedData;
    }

    /**
     * @param int $brandId
     * @return array
     */
    public function getCarModels(int $brandId): array
    {
        return \App\Models\Category::query()->where('parent', 'car_model')
            ->where('brand_id', $brandId)
            ->pluck('name', 'id')
            ->toArray();
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
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [
            new TopSellingProductsLens(),
            new LeastSellingProductsLens(),
            new TopSearchQueriesLens(),
        ];
    }

    /**
     * ID'ye göre kategori adını getirir
     *
     * @param int|null $id
     * @return string
     */
    public function getCategoryNameById(?int $id): string
    {
        if (!$id) return '-';

        return \App\Models\Category::find($id)->name ?? '-';
    }

}
