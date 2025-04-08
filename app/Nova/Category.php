<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\FormData;

class Category extends Resource
{
    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Kateqoriyalar';
    }

    public static function singularLabel(): string
    {
        return 'Kateqoriya';
    }

    /**
     * @var string
     */
    public static $model = \App\Models\Category::class;

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
        'id', 'name',
    ];

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Adı', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make("Aid olduğu kateqoriya", "parent")
                ->sortable()
                ->rules('required')
                ->options([
                    'product_type' => "Məhsul növü",
                    'brand' => "Brend",
                    'product_category' => "Kateqoriya",
                    'car_brand' => "Avtomobilin markası",
                    'car_model' => "Avtomobilin modeli",
                ])
                ->displayUsingLabels()
                ->readonly(function (NovaRequest $request) {
                    if ($request->isUpdateOrUpdateAttachedRequest()) {
                        return $this->parent === 'car_brand';
                    }
                    return false;
                }),

            Select::make('Avtomobilin markası', 'brand_id')
                ->sortable()
                ->dependsOn(['parent'], function (Select $field, NovaRequest $request, FormData $formData) {
                    if ($formData->get('parent') === 'car_model') {
                        $field->show();
                    } else {
                        $field->hide();
                    }
                })
                ->rules(function (NovaRequest $request) {
                    return $request->get('parent') == 'car_model'
                        ? ['required']
                        : [];
                })
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    if ($request->get('parent') != 'car_model') {
                        $model->{$attribute} = 0;
                    } else {
                        $model->{$attribute} = $request->get($requestAttribute) ?? 0;
                    }
                })
                ->options($this->brands())
                ->displayUsing(function ($value) {
                    $brand = $this->brands()[$value] ?? null;

                    if (!$brand) {
                        return '-';
                    }

                    return $brand;
                }),
        ];
    }

    /**
     * @return array
     */
    public function brands(): array
    {
        $formattedData = [];
        $models = \App\Models\Category::query()->where("parent", 'car_brand')->get()->toArray();

        foreach ($models as $model) {
            $formattedData[$model['id']] = $model['name'];
        }
        return $formattedData;
    }

    /**
     * @param Request $request
     * @return false
     */
    public function authorizedToReplicate(Request $request): false
    {
        return false;
    }
}
