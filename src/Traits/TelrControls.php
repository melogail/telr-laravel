<?php

namespace Melogail\TelrLaravel\Traits;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Melogail\TelrLaravel\TelrTransaction;
use Ramsey\Uuid\Uuid;

trait TelrControls
{
    /**
     * The customer's title [Optional]. if used, this should
     * be a value such as 'Mr', 'Mrs' etc. It does not refer
     * to details such as job title.
     */
    private string $bill_title;

    /**
     * Forenames [Required]. The customer's forename,
     * plus any other middle names or initials they may have.
     */
    private string $bill_fname = '';

    /**
     * Surename [Required]. Customer surname (also known as
     * family name).
     */
    private string $bill_sname = '';

    /**
     * Address line 1 [Required].
     */
    private string $bill_addr1 = '';

    /**
     * Address line 2 [Optional].
     */
    private string $bill_addr2 = '';

    /**
     * Address line 3 [Optional].
     */
    private string $bill_addr3 = '';

    /**
     * Customer mobile number [Required].
     */
    private string $bill_phone = '';

    /**
     * City [Required].
     */
    private string $bill_city = '';

    /**
     * Region/State [Optional].
     */
    private string $bill_region = '';

    /**
     * Country [Required]. Must be supplied as a 2 character
     * ISO 3166 country code.
     */
    private string $bill_country = '';

    /**
     * Post/Area/Zip code [Optional].
     */
    private string $bill_zip = '';

    /**
     * Email address [Required].
     */
    private string $email = '';

    /**
     * Payment page interface language [Optional].
     * if used, this should be a value 'en' or 'ar'
     * which are the currently supported languages.
     */
    private string $ivp_lang = '';

    /**
     * Transaction type [Optional]. Configure default
     * merchant admin is used if not set.
     */
    private string $ivp_trantype = '';

    /**
     * Transaction advice service type URL [Optional]. Set
     * a transaction advice service type URL on a per-transaction
     * basis.
     */
    private string $ivp_update_url = '';

    /**
     * @return $this
     */
    public function setIvpMethod(string $ivp_method)
    {
        $this->ivp_method = $ivp_method;

        return $this;
    }

    /**
     * @return string
     */
    public function getIvpMethod()
    {
        return $this->ivp_method;
    }

    /**
     * @return $this
     */
    public function setStoreId()
    {
        $this->ivp_store = config('telr-laravel.ess_params.ivp_store');

        return $this;
    }

    public function getStoreId()
    {
        return $this->ivp_store;
    }

    /**
     * @return $this
     */
    public function setAuthkey()
    {
        $this->ivp_authkey = config('telr-laravel.ess_params.ivp_authkey');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getAuthkey()
    {
        return $this->ivp_authkey;
    }

    /**
     * @return $this
     */
    public function setTestMode()
    {
        $this->ivp_test = config('telr-laravel.telr_test_mode');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|int|mixed
     */
    public function getTestMode()
    {
        return $this->ivp_test;
    }

    /**
     * @return $this
     */
    public function setCartId($cart)
    {
        $this->ivp_cart = $cart;

        return $this;
    }

    /**
     * @return string
     */
    public function getCartId()
    {
        return $this->ivp_cart;
    }

    /**
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->ivp_amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->ivp_amount;
    }

    /**
     * @return $this
     */
    public function setDesc($desc)
    {
        $this->ivp_desc = $desc;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->ivp_desc;
    }

    /**
     * @return $this
     */
    public function setCurrency()
    {
        $this->ivp_currency = config('telr-laravel.telr_currency');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getCurrency()
    {
        return $this->ivp_currency;
    }

    /**
     * @return $this
     */
    public function setReturnAuth()
    {
        $this->return_auth = config('telr-laravel.response_path.return_auth');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getReturnAuth()
    {
        return $this->return_auth;
    }

    /**
     * @return $this
     */
    public function setReturnDecl()
    {
        $this->return_decl = config('telr-laravel.response_path.return_decl');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getReturnDecl()
    {
        return $this->return_decl;
    }

    /**
     * @return $this
     */
    public function setReturnCan()
    {
        $this->return_can = config('telr-laravel.response_path.return_can');

        return $this;
    }

    /**
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getReturnCan()
    {
        return $this->return_can;
    }

    /**
     * @return $this
     */
    public function setReferenceCode($reference_code)
    {
        $this->reference_code = $reference_code;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceCode()
    {
        return $this->reference_code;
    }

    /**
     * Get order ID, the property value is set inside the
     * makePayment() method.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return $this
     */
    public function setBillTitle($bill_title)
    {
        $this->bill_title = $bill_title;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillTitle($bill_title)
    {
        return $this->bill_title;
    }

    /**
     * @return $this
     */
    public function setBillFname($bill_fname)
    {
        $this->bill_fname = $bill_fname;

        return $this;
    }

    /**
     * @param $bill_fname
     * @return string
     */
    public function getBillFname()
    {
        return $this->bill_fname;
    }

    /**
     * @return $this
     */
    public function setBillSname($bill_sname)
    {
        $this->bill_sname = $bill_sname;

        return $this;
    }

    /**
     * @param $bill_sname
     * @return string
     */
    public function getBillSname()
    {
        return $this->bill_sname;
    }

    /**
     * @return $this
     */
    public function setBillAddr1($bill_add1)
    {
        $this->bill_addr1 = $bill_add1;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillAddr1()
    {
        return $this->bill_addr1;
    }

    /**
     * @return $this
     */
    public function setBillAddr2($bill_addr2)
    {
        $this->bill_addr2 = $bill_addr2;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillAddr2()
    {
        return $this->bill_addr2;
    }

    /**
     * @return $this
     */
    public function setBillAddr3($bill_addr3)
    {
        $this->bill_addr3 = $bill_addr3;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillAddr3()
    {
        return $this->bill_addr3;
    }

    /**
     * @return $this
     */
    public function setBillPhone($bill_phone)
    {
        $this->bill_phone = $bill_phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillPhone()
    {
        return $this->bill_phone;
    }

    /**
     * @return $this
     */
    public function setBillCity($bill_city)
    {
        $this->bill_city = $bill_city;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillCity()
    {
        return $this->bill_city;
    }

    /**
     * Set $bill_region
     */
    public function setBillRegion($bill_region)
    {
        $this->bill_region = $bill_region;

        return $this;
    }

     /**
      * Get $bill_region
      */
     public function getBillRegion()
     {
         return $this->bill_region;
     }

     /**
      * Set $bill_country
      */
     public function setBillCountry($bill_country)
     {
         $this->bill_country = $bill_country;

         return $this;
     }

      /**
       * Get $bill_country
       */
      public function getBillCountry()
      {
          return $this->bill_country;
      }

      /**
       * Set $bill_zip
       */
      public function setBillZip($bill_zip)
      {
          $this->bill_zip = $bill_zip;

          return $this;
      }

       /**
        * Get $bill_zip
        */
       public function getBillZip()
       {
           return $this->bill_zip;
       }

       /**
        * Set $email
        */
       public function setEmail($email)
       {
           $this->email = $email;

           return $this;
       }

        /**
         * Get $email
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set $ivp_lang
         */
        public function setIvpLang($ivp_lang)
        {
            $this->ivp_lang = $ivp_lang;

            return $this;
        }

         /**
          * Get $ivp_lang
          */
         public function getIvpLang()
         {
             return $this->ivp_lang;
         }

         /**
          * Set $ivp_trantype
          */
         public function setIvpTranType($ivp_trantype)
         {
             $this->ivp_trantype = $ivp_trantype;

             return $this;
         }

          /**
           * Get $ivp_trantype
           */
          public function getIvpTranType()
          {
              return $this->ivp_trantype;
          }

          /**
           * Set $ivp_update_url
           */
          public function setIvpUpdateUrl($ivp_update_url)
          {
              $this->ivp_update_url = $ivp_update_url;

              return $this;
          }

           /**
            * Get $ivp_update_url
            */
           public function getIvpUpdateUrl()
           {
               return $this->ivp_update_url;
           }

    /**
     * Bootstrap essential params
     */
    public function bootstrap(): void
    {
        $this->setStoreId();
        $this->setAuthkey();
        $this->setCurrency();
        $this->setTestMode();
        $this->setReturnAuth();
        $this->setReturnDecl();
        $this->setReturnCan();
    }

    /**
     * Set transaction response
     *
     * @return TelrControls
     */
    public function setResponse($response)
    {
        $this->response = json_decode($response)->order;

        // Set the reference code if there is response
        $this->setReferenceCode($this->response->ref);

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

        // If response has error
        $response = json_decode($response);

        if (isset($response->error)) {
            throw new \Exception($response->error->message.'.Note: '.$response->error->note);
        }

        return true;
    }

    /**
     * For checking for transaction details
     *
     * @return PromiseInterface|Response
     */
    public function checkPayment($reference_code)
    {
        $this->setIvpMethod('check');

        $params = [
            'ivp_method' => $this->getIvpMethod(),
            'ivp_store' => $this->getStoreId(),
            'ivp_authkey' => $this->getAuthkey(),
            'order_ref' => $reference_code,
        ];

        $client = Http::asForm()->post($this->endpoint_link, $params);

        $this->isFailed($client);

        return $client;
    }

    /**
     * For making payment
     *
     * @return $this
     */
    public function makePayment(string $order_id, float $amount, string $order_description)
    {
        $this->order_id = $order_id;
        $this->ivp_amount = $amount;
        $this->ivp_desc = $order_description;
        $this->ivp_cart = Uuid::uuid4()->toString();
        $this->setIvpMethod('create');

        return $this;
    }

    /**
     * Update transaction status based on cart-id
     *
     * @return void
     */
    public function updateTransactionStatus($ref_code, $result)
    {
        $transactions = TelrTransaction::where('reference_code', $ref_code)->first();

        // Update the order based on the status of the transaction
        $negative_action = [-1, -2, -3];
        if (in_array($result->order->status->code, $negative_action)) {
            $transactions->update(
                [
                    'reference_code' => $result->order->ref,
                    'status_code' => $result->order->status->code,
                    'status_text' => $result->order->status->text,
                ]
            );

        } else {

            $transactions->update(
                [
                    'reference_code' => $result->order->ref,
                    'fname' => $result->order->customer->name->forenames,
                    'sname' => $result->order->customer->name->surname,
                    'bill_addr1' => $result->order->customer->address->line1.', '.$result->order->customer->address->city.','.$result->order->customer->address->country,
                    'bill_phone' => $result->order->customer->address->mobile,
                    'bill_city' => $result->order->customer->address->city,
                    'bill_country' => $result->order->customer->address->country,
                    'email' => $result->order->customer->email,
                    'status_code' => $result->order->status->code,
                    'status_text' => $result->order->status->text,
                ]
            );
        }
    }

    /**
     * Check for essential billing parameters
     *
     * @return void
     *
     * @throws \Exception
     */
    public function checkForUserRequiredParameters(array $parameters)
    {
        $required_parameters = [
            'bill_fname',
            'bill_sname',
            'bill_addr1',
            'bill_phone',
            'bill_city',
            'bill_country',
            'bill_email',
        ];

        foreach ($required_parameters as $parameter) {
            if (! array_key_exists($parameter, $parameters)) {
                throw new \Exception('[Error]: "'.$parameter.'" is required for your billing parameters.');
            }
        }
    }
}
