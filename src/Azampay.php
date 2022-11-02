<?php

namespace Alphaolomi\Azampay;

use Alphaolomi\Azampay\Support\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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

    /**
     * Sandbox Api Key
     */
    private $apiKey;

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
            if (!isset($this->options[$key]) || empty($this->options[$key])) {
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
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        if ($options['environment'] === 'sandbox') {
            $headers['X-API-Key'] = $this->apiToken;
        }

        return ($client instanceof Client) ?? new Client(['headers' => $headers]);
    }

    /**
     * Generate Token
     *
     * Generate the access token in order to access Azampay public end points.
     *
     * @throws \RuntimeException
     * @return AccessToken
     */
    public function generateToken(): AccessToken
    {
        try {
            $response = $this->httpClient->request("GET", $this->authBaseUrl . '/AppRegistration/GenerateToken');
            $data = $response->body()['data'];
            return AccessToken::create($data);
        } catch (\GuzzleHttp\Exception\ClientException $ce) {
            if ($ce->hasResponse()) {
                if ($ce->getResponse->getStatusCode() === 423) {
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
     * @return string
     */
    public function _getTokenString(null|string|array|AccessToken $accessToken = null): string
    {
        if (!is_null($accessToken)) {
            $_accessToken = AccessToken::create($accessToken);
            if (!$_accessToken->hasExpired()) {
                return $accessToken->getToken();
            }
        }

        if (!is_null($this->accessToken)  && !$this->accessToken->hasExpired()) {
            return $this->accessToken->getToken();
        }

        $token = $this->generateToken();
        $this->accessToken = $token;
        return $token;
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
     * @throws \RuntimeException
     * @param array $data
     * @return mixed
     */
    public function mobileCheckout(array $data, string $accessToken = null)
    {

        $data["accountNumber"] = Helper::cleanMobileNumber($data["accountNumber"]);
        $data["amount"] = Helper::cleanAmount($data["amount"]);

        $_accessToken = $this->_getTokenString($accessToken);
        try {

            $response = $this->httpClient->request(
                "POST", $this->baseUrl . '/azampay/mno/checkout', ["Authorization" => "Bearer {$_accessToken}"], ["body" => $data]
            );
            return json_decode($response->body());
        } catch (\GuzzleHttp\Exception\ClientException $ce) {
            if ($ce->hasResponse()) {
                if ($ce->getResponse->getStatusCode() === 400) {
                    throw new \RuntimeException("Permission denied.");
                }
            }
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
     * @throws \RuntimeException
     * @param array $data
     * @return mixed
     */
    public function bankCheckout(array $data, string $accessToken = null)
    {
        $data["amount"] = Helper::cleanAmount($data["amount"]);
        try {
            $_accessToken = $this->_getTokenString($accessToken);

            $response = $this->httpClient->request(
                "POST",
                $this->baseUrl . '/azampay/mno/checkout',
                ["Authorization" => "Bearer {$_accessToken}"],
                ["body" => $data]
            );

            return json_decode($response->body());
        } catch (\GuzzleHttp\Exception\ClientException $ce) {
            if ($ce->hasResponse()) {
                if ($ce->getResponse->getStatusCode() === 400) {
                    throw new \RuntimeException("Permission denied.");
                }
            }
        }
    }
}
