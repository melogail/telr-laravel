<?php

namespace Melogail\TelrLaravel\Listeners;

use Melogail\TelrLaravel\Events\TelrLaravelCreateRequestEvent;
use Melogail\TelrLaravel\TelrTransaction;

class TelrLaravelCreateRequestListener
{

    /**
     * TelrTransaction model holder
     *
     * @var TelrTransaction
     */
    protected $model;

    public function __construct(TelrTransaction $model)
    {
        $this->model = $model;
    }


    public function handle(TelrLaravelCreateRequestEvent $event)
    {

        $this->model->create([
            'cart_id'        => $event->telr->getCartId(),
            'order_id'       => $event->telr->getOrderId(),
            'reference_code' => $event->telr->getReferenceCode(),
            'amount'         => $event->telr->getAmount(),
            'test_mode'      => $event->telr->getTestMode(),
            'description'    => $event->telr->getDesc(),
            'fname'          => 'test fname',
            'sname'          => 'test sname',
            'bill_addr1'     => 'test bill_addr1',
            'bill_phone'     => 'test bill_phone',
            'bill_city'      => 'test bill_city',
            'bill_region'    => 'test bill_region',
            'bill_country'   => 'eg',
            'email'          => 'test email',
            'response'       => json_encode($event->telr->response()),

        ]);

    }

}
