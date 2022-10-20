<?php

namespace Alphaolomi\Azampay;

use GuzzleHttp\Client;

// use InvalidArgumentException;

/**
 * @author Alpha Olomi <alphaolomi@gmail.com>
 */
class Azampay
{
    public const SANDBOX_AUTH_BASE_URL = 'https://authenticator-sandbox.azampay.co.tz';

    public const SANDBOX_BASE_URL = 'https://sandbox.azampay.co.tz';

    // FIXME: add prod/live base url

    public const AUTH_BASE_URL = '';

    public const BASE_URL = '';

    public const SUPPORTED_MNO = ['Airtel', 'Tigo', 'Halopesa', 'Azampesa'];

    public const SUPPORTED_BANK = ['CRDB', 'NMB'];

    public const SUPPORTED_CURRENCY = ['TZS'];


    protected Client $httpClient;

    private $baseUrl;

    private $authBaseUrl;

    private $apiKey;

    /**
     * ## Example 1
     *  ```php
     *  const azampayService = new Azampay([
     *    "appName" => "ABC Shop",
     *    "clientId" => "YOUR_CLIENT_ID",
     *    "clientSecret" => "A_VERY_LONG_STRING",
     *    "environment" => "sandbox", // live
     * ]);
     * ```
     *
     * ## Example 2
     *  ```php
     *  const azampayService = new Azampay([
     *    "appName" => "ABC Shop",
     *    "clientId" => "YOUR_CLIENT_ID",
     *    "clientSecret" => "A_VERY_LONG_STRING",
     *    "environment" => "sandbox", // live
     *  ],
     *  new GuzzleHttp/Client([
     *     'headers' => [
     *         'Accept' => 'application/json',
     *         'Content-Type' => 'application/json',
     *         'X-API-Key' => "{$this->apiToken}",
     *     ],
     * ])
     * );
     */
    public function __construct(
        private array $options = [],
        ?Client $httpClient = null
    ) {
        foreach (['appName', 'clientId', 'clientSecret'] as $key) {
            if (! isset($this->options[$key]) || empty($this->options[$key])) {
                throw new \InvalidArgumentException("Missing required option: $key");
            }
        }

        $this->options['environment'] = $this->options['environment'] ?? 'sandbox';

        $this->baseUrl = $this->options['environment'] === 'sandbox' ? self::SANDBOX_BASE_URL : self::BASE_URL;
        $this->authBaseUrl = $this->options['environment'] === 'sandbox' ? self::SANDBOX_AUTH_BASE_URL : self::AUTH_BASE_URL;
        $this->httpClient = $this->makeClient($options, $httpClient);
    }

    protected function makeClient(array $options, ?Client $client = null): Client
    {
        return ($client instanceof Client) ? $client : new Client([
            // FIXME: add default timeout
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-Key' => "{$this->apiToken}",
            ],
        ]);
    }

    /**
     * Generate Token
     *
     * Generate the access token in order to access Azampay public end points.
     *
     * @return array
     */
    public function generateToken(): array
    {
        try {
            return $this->httpClient->get($this->authBaseUrl . '/AppRegistration/GenerateToken');
        } catch (\Throwable $th) {
            // if ($response->status() === 423) {
            // throw new \Exception('Provided detail is not valid for this app or secret key has been expired');
            // }
        }
    }

    /**
     *
     *
     * ```php
     * $data = [
     *     "accountNumber" =>  "string",
     *     "additionalProperties" =>  [
     *         "property1" =>  null,
     *         "property2" =>  null
     *     ],
     *     "amount" =>  "string",
     *     "currency" =>  "string",
     *     "externalId" =>  "string",
     *     "provider" =>  "Airtel"
     * ];
     * ```
     * @param array $data
     * @return mixed
     */
    public function mobileCheckout(array $data)
    {
        try {
            $response = $this->httpClient->request("POST", $this->baseUrl . '/azampay/mno/checkout', $data);

            return json_decode($response->body());
        } catch (\Throwable $th) {
            // if ($response->status() === 400) {
            // throw new \RuntimeException($response->body());
            // }
        }
    }

    /**
     * ```php
     * $data = [
     *      "additionalProperties" => [
     *          "property1" => null,
     *          "property2" => null
     *      ],
     *      "amount" => "string",
     *      "currencyCode" => "string",
     *      "merchantAccountNumber" => "string",
     *      "merchantMobileNumber" => "string",
     *      "merchantName" => "string",
     *      "otp" => "string",
     *      "provider" => "CRDB",
     *      "referenceId" => "string"
     * ];
     * ```
     * @param array $data
     * @return mixed
     */
    public function bankCheckout(array $data)
    {
        try {
            $response = $this->httpClient->request(
                "POST",
                $this->baseUrl . '/azampay/mno/checkout',
                $data
            );

            return json_decode($response->body());
        } catch (\Throwable $th) {
            // if ($response->status() === 400) {
            // throw new \RuntimeException($response->body());
            // }
        }
    }
}
