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
            'fname'          => $event->telr->getBillFname(),
            'sname'          => $event->telr->getBillSname(),
            'bill_addr1'     => $event->telr->getBillAddr1(),
            'bill_addr2'     => $event->telr->getBillAddr2() ?? null,
            'bill_addr3'     => $event->telr->getBillAddr3() ?? null,
            'bill_phone'     => $event->telr->getBillPhone(),
            'bill_city'      => $event->telr->getBillCity(),
            'bill_region'    => $event->telr->getBillRegion() ?? null,
            'bill_country'   => $event->telr->getBillCountry(),
            'bill_zip'       => $event->telr->getBillZip() ?? null,
            'email'          => $event->telr->getEmail(),
            'vip_lang'       => $event->telr->getVipLang() ?? null,
            'vip_trantype'   => $event->telr->getVipTranType() ?? null,
            'vip_update_url' => $event->telr->getVipUpdateUrl() ?? null,
            'response'       => json_encode($event->telr->response()),

        ]);

    }

}
