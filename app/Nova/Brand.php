<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Brand extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Slider>
     */
    public static $model = \App\Models\Brand::class;

    /**
     * @var int[]
     */
    public static $perPageOptions = [10];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Image::make('Image', 'image')
                ->disk('public')
                ->path('brands')
                ->rules('required')
        ];
    }

    public static function singularLabel(): string
    {
        return 'Image';
    }

    public static function label(): string
    {
        return 'Slayder (brendlər)';
    }

    public function authorizedToReplicate(Request $request): false
    {
        return false;
    }
}
