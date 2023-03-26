<?php

namespace Melogail\TelrLaravel\Listeners;

use Melogail\TelrLaravel\Events\TelrLaravelCreateRequestEvent;
use Melogail\TelrLaravel\Events\TelrLaravelUpdateCartStatusEvent;
use Melogail\TelrLaravel\TelrLaravel;
use Melogail\TelrLaravel\TelrTransaction;

class TelrLaravelUpdateCartStatusListener
{



    public function __construct()
    {
        //
    }


    public function handle(TelrLaravelUpdateCartStatusEvent $event)
    {
        // Update the transaction status
        $event->telr->updateTransactionStatus($event->ref_code, $event->result);

    }

}
