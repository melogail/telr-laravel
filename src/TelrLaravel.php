<?php

namespace Melogail\TelrLaravel;

use Illuminate\Support\Facades\Http;
use Melogail\TelrLaravel\Traits\TelrControls;
use Ramsey\Uuid\Uuid;

class TelrLaravel
{
    use TelrControls;


    /**
     * Package version
     *
     * @var string
     */
    public string $version = '1.0.0';


    /**
     * The payment amount.
     *
     * @var float
     */
    private $amount = 0.0;


    /**
     * Cart ID set by the payment gateway.
     */
    private string $cart_id;


    /**
     * Order ID set by system.
     */
    private string $order_id;


    /**
     * Order description
     */
    private string $order_description;


    /**
     * Billing Parameters.
     */
    private array $billing_params = [];


    /**
     * Set the sales endpoint link that will accept the
     * parameters that will be sent to the payment
     * gateway. For more information see the part
     * "Request method and format" on the link
     *
     * https://telr.com/support/knowledge-base/hosted-payment-page-integration-guide/
     */
    private string $endpointLink = 'https://secure.telr.com/gateway/order.json';


    /**
     * Method sent to "create" or "check" order.
     */
    private string $ivp_method;


    /**
     * Payment response object
     *
     * @var object
     */
    private object $response;


    /**
     * Create constructor
     */
    public function __construct($order_id, $amount, $order_description)
    {
        $this->order_id = $order_id;
        $this->amount = $amount;
        $this->order_description = $order_description;
        $this->cart_id = Uuid::uuid4()->toString();
    }


    /**
     * Perform the payment
     *
     * @return TelrLaravel
     */
    public function pay(array $params = [])
    {
        // Essential parameters
        $parameters = [
            'ivp_method'   => $this->getIvpMethod(),
            'ivp_store'    => config('telr-laravel.ess_params.ivp_store'),
            'ivp_authkey'  => config('telr-laravel.ess_params.ivp_authkey'),
            'ivp_test'     => config('telr-laravel.telr_test_mode'),
            'ivp_cart'     => $this->cart_id,
            'ivp_amount'   => $this->amount,
            'ivp_desc'     => $this->order_description,
            'ivp_currency' => config('telr-laravel.telr_currency'),
            'return_auth'  => url(config('telr-laravel.response_path.return_auth')),
            'return_decl'  => url(config('telr-laravel.response_path.return_decl')),
            'return_can'   => url(config('telr-laravel.response_path.return_can')),
        ];

        // Merge user parameters
        if (!empty($params)) {
            $parameters = array_merge($parameters, $params);
        }

        // Send request and receive response
        $response = Http::asForm()->post($this->endpointLink, $parameters);

        // If failed, throw exception
        $this->isFailed($response);

        // Fetch the response
        $this->setResponse($response);

        return $this;
    }


    /**
     * Return the response object
     *
     * @return object
     */
    public function response()
    {
        return $this->response;

    }

}
