<?php

namespace Melogail\TelrLaravel\Traits;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

trait TelrControls
{
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

    public function setResponse($response)
    {
        $this->response = json_encode($response);
    }

    /**
     * If payment is failed
     *
     * @throws RequestException
     */
    public function isFailed(Response $response)
    {
        if ($response->failed()) {
            return $response->throw();
        }

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
    public function makePayment()
    {
        $this->setIvpMethod('create');

        return $this;
    }

}
