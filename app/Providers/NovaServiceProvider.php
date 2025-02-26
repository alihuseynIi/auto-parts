<?php

namespace App\Providers;

use App\Nova\Category;
use App\Nova\Dashboards\Report;
use App\Nova\Order;
use App\Nova\OrderItem;
use App\Nova\Product;
use App\Nova\Slider;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::initialPath('/resources/products');

        Nova::mainMenu(function (Request $request) {
            return [
//                MenuSection::dashboard(Report::class)->icon('chart-bar'),

                MenuSection::make('Məhsullar', [
                    MenuItem::resource(Category::class),
                    MenuItem::resource(Product::class),
                ])->icon('shopping-bag')->collapsable(),

                MenuSection::make('Satışlar', [
                    MenuItem::resource(Order::class),
                    MenuItem::resource(OrderItem::class),
                ])->icon('shopping-cart')->collapsable(),


                MenuSection::make('Digər', [
                    MenuItem::resource(Slider::class),
                    MenuItem::resource(User::class),
                ])->icon('menu')->collapsable(),
            ];
        });

        Nova::showUnreadCountInNotificationCenter();
        Nova::style('custom-nova', public_path('nova-custom.css'));
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
//            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return $user->is_admin == 1;
        });
    }

    /**
     * @return void
     */
    protected function authorization(): void
    {
        $this->gate();

        Nova::auth(function ($request) {
            return Gate::check('viewNova', [$request->user()]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new Report,
        ];
    }
}
