<?php

return [

    /*
     |--------------------------------------------------
     | Telr Current Mode
     |--------------------------------------------------
     | The current model type you are using in your
     | project, it can be either "test" mode = 0 or
     | 'live' mode = 1.
     |
     */

    'telr_test_mode' => env('TELR_TEST_MODE'),


    /*
     |--------------------------------------------------
     | Currency Used
     |--------------------------------------------------
     | The currency used by your project for payment,
     | it can be any currency with 3 characters ISO
     | code, ex: USD, AED, EGP, GBP
     |
     */

    'telr_currency'  => env('TELR_CURRENCY'),


    /*
     |--------------------------------------------------
     | Essential Parameters
     |--------------------------------------------------
     | The essential parameters needed to send data
     | to telr payment gateway.
     |
     */

    'ess_params' => [
        'ivp_store'   => env('TELR_STORE_ID'),
        'ivp_authkey' => env('TELR_AUTH_KEY'),

    ],


    /*
     |--------------------------------------------------
     | Response Return Paths
     |--------------------------------------------------
     | The essential parameters needed to send data
     | to telr payment gateway.
     |
     | return_auth: Will redirect the user to success page
     | return_decl: Will redirect the user to decline page
     | return_can : Will redirect the user to cancel page
     |
     */

    'response_path' => [
        'return_auth' => '/payment/success',
        'return_decl' => '/payment/declined',
        'return_can'  => '/payment/canceled'

    ]

];
