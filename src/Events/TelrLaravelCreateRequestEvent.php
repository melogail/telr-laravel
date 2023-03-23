<?php

namespace Melogail\TelrLaravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Melogail\TelrLaravel\TelrLaravel;


class TelrLaravelCreateRequestEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $telr;

    public function __construct(TelrLaravel $telr)
    {
        $this->telr = $telr;
    }

}
