<?php

namespace Alphaolomi\Azampay;

use Alphaolomi\Azampay\Support\Helpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @author Alpha Olomi <alphaolomi@gmail.com>
 */
class Azampay
{
    public const SANDBOX_AUTH_BASE_URL = 'https://authenticator-sandbox.azampay.co.tz';

    public const SANDBOX_BASE_URL = 'https://sandbox.azampay.co.tz';

    public const AUTH_BASE_URL = 'https://authenticator.azampay.co.tz';

    public const BASE_URL = 'https://checkout.azampay.co.tz';

    public const SUPPORTED_MNO = ['Airtel', 'Tigo', 'Halopesa', 'Azampesa'];

    public const SUPPORTED_BANK = ['CRDB', 'NMB'];

    public const SUPPORTED_CURRENCY = ['TZS'];


    protected Client $httpClient;

    private string $baseUrl;

    private string $authBaseUrl;

    private ?AccessToken $accessToken = null;

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
     *         'X-API-Key' => "YOUR_API_TOKEN",
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

        $this->options['environment'] = ! isset($this->options['environment']) ?? 'sandbox';

        $this->baseUrl = $this->options['environment'] === 'sandbox' ? self::SANDBOX_BASE_URL : self::BASE_URL;
        $this->authBaseUrl = $this->options['environment'] === 'sandbox' ? self::SANDBOX_AUTH_BASE_URL : self::AUTH_BASE_URL;
        $this->httpClient = $this->makeClient($this->options, $httpClient);
    }

    protected function makeClient(array $options, ?Client $client = null): Client
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        //        if ($options['environment'] === 'sandbox') {
        //            $headers['X-API-Key'] = $this->apiToken;
        //        }
        if ($client === null) {
            $client = new Client(['headers' => $headers,]);
        }

        return $client;
    }

    /**
     * Generate Token
     *
     * Generate the access token in order to access Azampay public end points.
     *
     * @throws \RuntimeException|\GuzzleHttp\Exception\GuzzleException
     */
    public function generateToken()
    {
        $data = [];

        try {
            $response = $this->httpClient->request(
                "GET",
                $this->authBaseUrl . '/AppRegistration/GenerateToken'
            );
            $data = json_decode((string)$response->getBody(), true);

            return AccessToken::create($data['data']);
        } catch (\GuzzleHttp\Exception\ClientException $ce) {
            if ($ce->hasResponse()) {
                if ($ce->getResponse()->getStatusCode() === 423) {
                    throw new \RuntimeException('Provided detail is not valid for this app or secret key has been expired');
                }
            }
        }
    }

    /**
     * Get Token string
     *
     * Generate the access token in order to access Azampay public end points.
     *
     * @param string|array|AccessToken|null $accessToken
     * @return string
     * @throws GuzzleException
     */
    public function _getTokenString(null|string|array|AccessToken $accessToken = null): string
    {
        // if given token is not null
        if (! is_null($accessToken)) {
            $_accessToken = AccessToken::create($accessToken);
            // fixme: if (!$_accessToken->hasExpired()) {
            // save given token
            $this->accessToken = $_accessToken;
            // return AT
            return $_accessToken->getToken();
            // }
        }

        // saved token is not null
        // fixme: && !$this->accessToken->hasExpired()
        if (! is_null($this->accessToken)) {
            // use saved AT
            return $this->accessToken->getToken();
        }

        // if user is null && expired
        // if saved is null && expired
        // geneate new
        $newToken = $this->generateToken();
        // save
        $this->accessToken = $newToken;
        // use new token
        return $newToken->getToken();
    }

    /**
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
     * @param null|array|string $accessToken
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mobileCheckout(array $data, string|array $accessToken = null): array
    {
        $data["accountNumber"] = Helpers::cleanMobileNumber($data["accountNumber"]);
        $data["amount"] = Helpers::cleanAmount($data["amount"]);


        $_accessToken = $this->_getTokenString($accessToken);

        //        try {
        $response = $this->httpClient->request(
            "POST",
            $this->baseUrl . '/azampay/mno/checkout',
            ["Authorization" => "Bearer $_accessToken", "json" => $data],
        );

        return json_decode((string)$response->getBody(), true);
        //        } catch (\GuzzleHttp\Exception\ClientException $ce) {
        //            if ($ce->hasResponse()) {
        //                if ($ce->getResponse()->getStatusCode() === 400) {
        //                    throw new \RuntimeException("Permission denied.");
        //                }
        //            }
        //        }
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
     * @param string|null $accessToken
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bankCheckout(array $data, string $accessToken = null): array
    {
        $data["amount"] = Helpers::cleanAmount($data["amount"]);

        //        try {
        $_accessToken = $this->_getTokenString($accessToken);

        $response = $this->httpClient->request(
            "POST",
            $this->baseUrl . '/azampay/mno/checkout',
            [
                "Authorization" => "Bearer $_accessToken",
                "json" => $data,
            ],
        );

        return json_decode((string)$response->getBody(), true);
        //        } catch (\GuzzleHttp\Exception\ClientException $ce) {
        //            if ($ce->hasResponse()) {
        //                if ($ce->getResponse()->getStatusCode() === 400) {
        //                    throw new \RuntimeException("Permission denied.");
        //                }
        //            }
        //        }
    }
}
