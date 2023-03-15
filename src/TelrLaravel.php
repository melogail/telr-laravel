<?php

namespace Melogail\TelrLaravel;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Ramsey\Uuid\Uuid;

class TelrLaravel
{
    /**
     * The payment amount
     *
     * @var float
     */
    private $amount = 0.0;

    /**
     * Cart ID set by the payment gateway
     *
     * @var
     */
    private $cart_id;

    /**
     * Order ID set by the system
     *
     * @var
     */
    private $order_id;

    /**
     * Billing Parameters
     *
     * @var array
     */
    private array $billing_params = [];

    /**
     * Create constructor
     *
     * @param $order_id
     * @param $amount
     */
    public function __construct($order_id, $amount)
    {
        $this->order_id = $order_id;
        $this->amount = $amount;
        $this->cart_id = Uuid::uuid4()->toString() . '-' . time();
    }


    /**
     * Send post request to the payment endpoint with payment
     * parameters.
     *
     * @param $end_point
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendPaymentRequest($end_point, array $params = [])
    {

        $client = new Client();
        $response = $client->post($end_point, $params);

        // Validate if the response has no errors and return 200.
        if (200 != $response->getStatusCode()) {
            throw new ClientException('The response is ' . $response->getStatusCode());
        }

        // Convert JSON response to object
        return json_decode($response->getBody()->getContents());

    }


    /**
     * TODO: This method will prepare the essential parameters for
     * sending the request to the payment gateway
     *
     * @return void
     */
    public function prepareParameters()
    {

    }

}
