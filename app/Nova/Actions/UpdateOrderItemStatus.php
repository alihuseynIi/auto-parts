<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class UpdateOrderItemStatus extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * @var string
     */
    public $name = 'Statusu Dəyişdir';

    /**
     * @var bool
     */
    public $showInline = true;

    /**
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        foreach ($models as $model) {
            $model->update(['status' => $fields->status]);
        }

        return Action::message('Status yeniləndi!');
    }

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Status', 'status')
                ->options([
                    'pending' => 'Gözləmədə',
                    'accepted' => 'Qəbul edildi',
                    'completed' => 'Tamamlandı',
                    'canceled' => 'Ləğv edildi',
                ])
                ->displayUsingLabels()
                ->rules('required'),
        ];
    }
}
