<?php

namespace App\Nova\Metrics;

use App\Models\User;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;
use Laravel\Nova\Nova;

class NewUsers extends Value
{
    /**
     * @var string
     */
    public $name = 'Yeni istifadəçilər';

    /**
     * @param NovaRequest $request
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->count($request, User::class);
    }

    /**
     * @return array
     */
    public function ranges(): array
    {
        return [
            'TODAY' => Nova::__('Bugün'),
            30 => Nova::__('30 Gün'),
            60 => Nova::__('60 Gün'),
            365 => Nova::__('365 Gün'),
        ];
    }

    /**
     * @return DateTimeInterface|null
     */
    public function cacheFor(): DateTimeInterface|null
    {
        return now()->addMinutes(10);
    }

    /**
     * @return string
     */
    public function uriKey(): string
    {
        return 'new-users';
    }
}
