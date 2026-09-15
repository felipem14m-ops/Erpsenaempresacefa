<?php

namespace Modules\SGC\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class SGCServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'SGC';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'sgc';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        \Illuminate\Support\Facades\View::composer(
            ['sgc::layouts.NavbarAdmin', 'sgc::Lider_Area.Dashboard', 'sgc::Lider_Area.*'],
            \Modules\SGC\Http\ViewComposers\NotificacionesComposer::class
        );
    }
}
