<?php

namespace Alphaolomi\Azampay;

/**
 * @author Alpha Olomi <alphaolomi@gmail.com>
 * @version 1.0.0
 */
class AccessToken
{
    private string $token;
    // "2022-11-03T14:12:40Z"
    private \DateTime $expireDate;

    public function __construct(string $token, string $expireDate)
    {
        $this->token = $token;
        $this->expireDate = new \DateTime($expireDate);
    }

    public static function createFromArray(array $data): AccessToken
    {
        return new AccessToken($data["token"], $data["expireDate"]);
    }

    public static function createFromString(string $str): AccessToken
    {
        try {
            $data = json_decode($str, true, 512, JSON_THROW_ON_ERROR);
            return new AccessToken($data["token"], $data["expireDate"]);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException("Invalid json string");
        }
    }

    public static function create(null|string|array|AccessToken $accessToken): AccessToken|string|null
    {
        if (is_string($accessToken)) {
            return AccessToken::createFromString($accessToken);
        }
        if (is_array($accessToken)) {
            return AccessToken::createFromArray($accessToken);
        }

        return $accessToken;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpireDate(): \DateTime
    {
        return $this->expireDate;
    }

    /**
     * Return Access token in JSON
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            "token" => $this->token,
            "expireDate" => $this->expireDate->format('Y-m-d\TH:i:s\Z'),
        ]);
    }

    public function hasExpired(): bool
    {
        return $this->expireDate > new \DateTime('now');
    }
}
