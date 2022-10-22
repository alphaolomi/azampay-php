<?php

namespace Alphaolomi\Azampay;

use InvalidArgumentException;

/**
 * @author Alpha Olomi <alphaolomi@gmail.com>
 */
class AccessToken
{
    private string $token;
    private string $expireDate;

    public function __construct(string $token, string $expireDate)
    {
        $this->token = $token;
        $this->expireDate = $expireDate;
    }

    public function createFromArray(array $data)
    {
        return new AccessToken($data["token"], $data["expireDate"]);
    }
    public function createFromString(string $str)
    {
        $data = json_decode($str);
        return new AccessToken($data["token"], $data["expireDate"]);
    }
    public static function create(null|string|array|AccessToken $accessToken)
    {
        if ($accessToken instanceof string) {
            return AccessToken::createFromString($accessToken);
        }
        if (is_array($accessToken)) {
            return AccessToken::createFromArray($accessToken);
        }
        return $accessToken;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Return Access token in JSON
     * @return string
     */
    public function toString()
    {
        return json_encode([
            "token" => $this->token,
            "expireDate" => $this->expireDate
        ]);
    }


    public function hasExpired(): bool
    {
        // fixme: use valid/correct date comparison
        return $this->expireDate < date('c');
    }
}
