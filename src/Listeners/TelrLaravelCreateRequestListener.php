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
            'cart_id' => $event->telr->getCartId(),
            'order_id' => $event->telr->getOrderId(),
            'reference_code' => $event->telr->getReferenceCode() ?? null,
            'amount' => $event->telr->getAmount(),
            'test_mode' => $event->telr->getTestMode(),
            'description' => $event->telr->getDesc(),
            'fname' => $event->telr->getBillFname() ?? null,
            'sname' => $event->telr->getBillSname() ?? null,
            'bill_addr1' => $event->telr->getBillAddr1() ?? null,
            'bill_addr2' => $event->telr->getBillAddr2() ?? null,
            'bill_addr3' => $event->telr->getBillAddr3() ?? null,
            'bill_phone' => $event->telr->getBillPhone() ?? null,
            'bill_city' => $event->telr->getBillCity() ?? null,
            'bill_region' => $event->telr->getBillRegion() ?? null,
            'bill_country' => $event->telr->getBillCountry() ?? null,
            'bill_zip' => $event->telr->getBillZip() ?? null,
            'email' => $event->telr->getEmail() ?? null,
            'ivp_lang' => $event->telr->getIvpLang() ?? null,
            'ivp_trantype' => $event->telr->getIvpTranType() ?? null,
            'ivp_update_url' => $event->telr->getIvpUpdateUrl() ?? null,
            'response' => json_encode($event->telr->response()),

        ]);
    }
}
