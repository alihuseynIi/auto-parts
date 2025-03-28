<?php

namespace App\Nova;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Nova\Auth\PasswordValidationRules;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravelwebdev\Repeatable\Repeatable;

class User extends Resource
{
    use PasswordValidationRules;

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'İstifadəçilər';
    }

    /**
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'İstifadəçi';
    }

    /**
     * @var string
     */
    public static string $model = \App\Models\User::class;

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
        'id', 'name', 'email',
    ];

    /**
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Ad', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('E-poçta', 'email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Şifrə', 'password')
                ->onlyOnForms()
                ->creationRules($this->passwordRules())
                ->updateRules($this->optionalPasswordRules()),


            Repeatable::make('Adreslər', 'addresses', [
                Text::make('address')->rules('required'),
            ])
                ->addRowLabel("Yeni Adres")
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {

                    $isAdmin = (bool)$request->input('is_admin');

                    // Sadece is_admin false ise adres zorunlu olsun
                    if (!$isAdmin && empty(json_decode($request['addresses'], true))) {
                        throw ValidationException::withMessages([
                            'addresses' => 'Minimum 1 adres əlavə edilməlidir.',
                        ]);
                    }

                    if (!$model->id) {
                        $model->save();
                    }

                    $newAddresses = json_decode($request->get('addresses'), true) ?? [];
                    $existingAddresses = UserAddress::query()->where('user_id', $model->id)->get();

                    $newAddressIds = [];
                    foreach ($newAddresses as $address) {
                        $userAddress = UserAddress::query()->updateOrCreate(
                            ['user_id' => $model->id, 'address' => $address['address']],
                            ['address' => $address['address']]
                        );

                        $newAddressIds[] = $userAddress->id;
                    }

                    $existingAddresses->each(function ($existingAddress) use ($newAddressIds) {
                        if (!in_array($existingAddress->id, $newAddressIds)) {
                            $existingAddress->delete();
                        }
                    });

                })->rules('required_unless:is_admin,1'),

            Boolean::make('Admin vəzifəsi', 'is_admin')
                ->sortable()
                ->trueValue(1)
                ->falseValue(0)
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
}
