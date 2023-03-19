<?php

namespace Melogail\TelrLaravel;

class Transaction extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'telr_transactions';

    protected $fillable = [
        'card_id',
        'order_id',
        'fname',
        'sname',
        'bill_addr1',
        'bill_addr2',
        'bill_addr3',
        'bill_phone',
        'bill_city',
        'bill_region',
        'bill_country',
        'bill_zip',
        'email',
        'ivp_lang',
        'ivp_trantype',
        'ivp_update_url',
        'txr_reference',
        'status',
        'response'
    ];

}
