<?php

namespace Melogail\TelrLaravel;

use Illuminate\Database\Eloquent\Model;

class TelrTransaction extends Model
{
    /**
     * Targeted
     *
     * @var string
     */
    protected $table = 'telr_transactions';

    protected $fillable = [
        'cart_id',
        'order_id',
        'reference_code',
        'amount',
        'fname',
        'sname',
        'test_mode',
        'description',
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
        'status_code',
        'status_text',
        'response',
    ];
}
