<?php

namespace Melogail\TelrLaravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Melogail\TelrLaravel\TelrLaravel;

class TelrLaravelUpdateCartStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TelrLaravel $telr;

    public string $ref_code;

    public string $email;

    public object $result;

    public function __construct(TelrLaravel $telr, $ref_code, $email, $result)
    {
        $this->telr = $telr;
        $this->email = $email;
        $this->ref_code = $ref_code;
        $this->result = $result;
    }
}
