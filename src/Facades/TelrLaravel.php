<?php

namespace Melogail\TelrLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see TelrLaravel
 */
class TelrLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'telr';
    }
}
