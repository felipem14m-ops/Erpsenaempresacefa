<?php

namespace Modules\SGC\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        \Modules\SGC\Events\SolicitudRadicada::class => [
            \Modules\SGC\Listeners\NotificarResponsableCalidad::class,
        ],
        \Modules\SGC\Events\SolicitudRespondida::class => [
            \Modules\SGC\Listeners\NotificarLiderArea::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
