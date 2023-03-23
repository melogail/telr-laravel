<?php

namespace Melogail\TelrLaravel;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Melogail\TelrLaravel\Events\TelrLaravelCreateRequestEvent;
use Melogail\TelrLaravel\Events\TelrLaravelUpdateCartStatusEvent;
use Melogail\TelrLaravel\Listeners\TelrLaravelCreateRequestListener;
use Melogail\TelrLaravel\Listeners\TelrLaravelUpdateCartStatusListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        TelrLaravelCreateRequestEvent::class => [
            TelrLaravelCreateRequestListener::class,
        ],

        TelrLaravelUpdateCartStatusEvent::class => [
            TelrLaravelUpdateCartStatusListener::class,

        ]
    ];
}
