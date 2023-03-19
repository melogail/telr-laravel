<?php

namespace Melogail\TelrLaravel;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class TelrLaravel
{
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
     * Create constructor
     */
    public function __construct($order_id, $amount)
    {
        $this->order_id = $order_id;
        $this->amount = $amount;
        $this->cart_id = Uuid::uuid4()->toString().'-'.time();
    }

    /**
     * Set ivp_method type for request
     *
     * @return $this
     */
    public function setIvpMethod(string $ivp_method)
    {
        $this->ivp_method = $ivp_method;

        return $this;
    }

    /**
     * Get ivp_method
     *
     * @return string
     */
    public function getIvpMethod()
    {
        return $this->ivp_method;
    }

    /**
     * @throws RequestException
     */
    public function paymentStatus(Response $response)
    {
        if ($response->successful()) {
            dd('Request sent successfully!');
        }

        dd($response->throw());
    }

    /**
     * Perform the payment
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|Response
     */
    public function pay(array $params = [])
    {
        // Essential parameters
        $parameters = [
            'ivp_method' => $this->getIvpMethod(),
            'ivp_store' => config('telr-laravel.ess_params.ivp_store'),
            'ivp_authkey' => config('telr-laravel.ess_params.ivp_authkey'),
            'ivp_test' => config('telr-laravel.telr_test_mode'),
            'ivp_amount' => $this->amount,
            'ivp_currency' => config('telr-laravel.telr_currency'),
            'return_auth' => config('telr-laravel.response_path.return_auth'),
        ];

        // Merge user parameters
        if (! empty($params)) {
            $parameters = array_merge($parameters, $params);
        }

        // Send request and receive response
        $response = Http::asForm()->post($this->endpointLink, $parameters);

        // TODO::Change the status to success
        //$this->paymentStatus($response);
        return $response;
        //return redirect(config('telr-laravel.response_path.return_auth'))->with($response->headers());
    }

    /**
     * For checking for transaction details
     *
     * @return $this
     */
    public function checkPayment()
    {
        $this->setIvpMethod('check');

        return $this;
    }

    /**
     * For making payment
     *
     * @return $this
     */
    public function makePayment($amount)
    {
        $this->setIvpMethod('create');
        $this->amount = $amount;

        return $this;
    }
}
