<?php

namespace Melogail\TelrLaravel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Melogail\TelrLaravel\Events\TelrLaravelCreateRequestEvent;
use Melogail\TelrLaravel\Events\TelrLaravelUpdateCartStatusEvent;
use Melogail\TelrLaravel\Traits\TelrControls;

class TelrLaravel
{
    use TelrControls;

    /**
     * Package version
     */
    public string $version = '1.0.3';

    /**
     * TelrTransaction model holder
     */
    private $model;

    /**
     * The request method being used. Set to 'create' to
     * generate a new transaction.
     */
    private string $ivp_method;

    /**
     * Your store ID. Numeric value only, on text. For
     * example, 1234 not 1234-store name.
     */
    private int $ivp_store;

    /**
     * Your authentication key
     */
    private string $ivp_authkey;

    /**
     * Transaction amount. In major units, for example 9 dollars
     * 50 cents must be as 9.50 not 950.
     */
    private float $ivp_amount;

    /**
     * Currency the transaction is in. 3 character ISO code.
     */
    private string $ivp_currency;

    /**
     * Test mode indicator. 0 = Live, 1 = Test.
     */
    private int $ivp_test;

    /**
     * Cart ID. Your reference for the
     * transaction. For example, this could be a
     * cart ID or order ID generated by your shopping
     * system. This must be unique for each request.
     * Maximum length is 63 characters.
     */
    private string $ivp_cart;

    /**
     * Order ID, this will be used to save your order ID
     * generated by the shopping system to be used as a
     * foreign key inside the database.
     */
    private string $order_id;

    /**
     * Purchase description. Maximum length is 63 characters.
     */
    private string $ivp_desc;

    /**
     * URL for authorised transactions. These are URLs within
     * your site, where the shopper will be directed to once
     * the transaction process is complete.
     */
    private string $return_auth;

    /**
     * URL for declined or failed transactions. These are URLs
     * within your site, where the shopper will be directed to once
     * the transaction process is complete.
     */
    private string $return_decl;

    /**
     * URL for cancelled transactions. These are URLs within
     * your site, where the shopper will be directed to once
     * the transaction process is complete.
     */
    private string $return_can;

    /**
     * Set the sales endpoint link that will accept the
     * parameters that will be sent to the payment
     * gateway. For more information see the part
     * "Request method and format" on the link
     *
     * https://telr.com/support/knowledge-base/hosted-payment-page-integration-guide/
     */
    private string $endpoint_link = 'https://secure.telr.com/gateway/order.json';

    /**
     * Payment response object
     */
    private object $response;

    /**
     * Get order reference sent if transaction is success.
     */
    private string $reference_code;

    /**
     * @param  string  $order_id
     * @param  float  $amount
     * @param  string  $order_description
     */
    public function __construct()
    {
        $this->model = new TelrTransaction();
        $this->bootstrap();
    }

    /**
     * Perform the payment
     *
     * @return TelrLaravel
     */
    public function pay(array $params = [])
    {
        // Essential parameters returned from config and on 'makePayment()' method.
        $parameters = [
            'ivp_method' => $this->getIvpMethod(),
            'ivp_store' => $this->getStoreId(),
            'ivp_authkey' => $this->getAuthkey(),
            'ivp_test' => $this->getTestMode(),
            'ivp_cart' => $this->getCartId(),
            'ivp_amount' => $this->getAmount(),
            'ivp_desc' => $this->getDesc(),
            'ivp_currency' => $this->getCurrency(),
            'return_auth' => url($this->getReturnAuth()).'?'.http_build_query(['cart_id' => $this->getCartId(), 'email' => $this->getEmail()]),
            'return_decl' => url($this->getReturnDecl()).'?'.http_build_query(['cart_id' => $this->getCartId(), 'email' => $this->getEmail()]),
            'return_can' => url($this->getReturnCan()).'?'.http_build_query(['cart_id' => $this->getCartId(), 'email' => $this->getEmail()]),
        ];

        if (! empty($params)) {
            // If the user required parameters are not pre-set, the payment gateway page will ask the user to
            // add these information.
            $this->checkForUserRequiredParameters($params);
        }

        // Merge user parameters
        if (! empty($params)) {
            $parameters = array_merge($parameters, $params);
        }

        // Send request and receive response
        $response = Http::asForm()->post($this->endpoint_link, $parameters);

        // If failed, throw exception
        $this->isFailed($response);

        // Fetch the response
        $this->setResponse($response);

        // Call event
        TelrLaravelCreateRequestEvent::dispatch($this);

        return $this;
    }

    /**
     * Update the status field to success.
     *
     * @return true
     */
    public function setTransactionStatus(Request $request)
    {
        // Get cart ID from URL query
        $cart_id = $request->query('cart_id');

        // Check for cart ID
        $cart = $this->hasCartId($cart_id);

        if ($cart) {
            // Get cart reference code.
            $cart_details = TelrTransaction::where('cart_id', $cart_id)->first();
            $cart_reference = $cart_details->reference_code;

            // Send cart reference to server to  transaction get status.
            $result = $this->checkPayment($cart_reference);

            TelrLaravelUpdateCartStatusEvent::dispatch($this, $cart_reference, json_decode($result));
        }

        return true;
    }

    /**
     * Validate reference code for transaction.
     *
     * @return true
     */
    public function hasCartId($cart_id)
    {
        $cart = $this->model->where('cart_id', $cart_id)->first();

        if (! $cart) {
            return abort(401);
        }

        return true;
    }
}
