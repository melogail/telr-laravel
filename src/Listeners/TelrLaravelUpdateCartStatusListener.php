<?php

namespace Melogail\TelrLaravel\Listeners;

use Melogail\TelrLaravel\Events\TelrLaravelUpdateCartStatusEvent;

class TelrLaravelUpdateCartStatusListener
{
    public function __construct()
    {
        //
    }

    public function handle(TelrLaravelUpdateCartStatusEvent $event)
    {
        // Update the transaction status
        $event->telr->updateTransactionStatus($event->ref_code, $event->email, $event->result);
    }
}
