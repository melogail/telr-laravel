<?php

namespace Melogail\TelrLaravel;

interface PaymentContract
{
    /**
     * Set the amount of payment for each transaction.
     *
     * @param $amount
     * @return mixed
     */
    public function setAmount($amount);

    /**
     * Return the amount of payment for each transaction.
     *
     * @param $amount
     * @return mixed
     */
    public function getAmount();
}
