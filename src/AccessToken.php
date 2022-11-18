<?php

namespace Alphaolomi\Azampay;

/**
 * @author Alpha Olomi <alphaolomi@gmail.com>
 * @version 1.0.0
 */
class AccessToken
{
    private string $accessToken;
    // "2022-11-03T14:12:40Z"
    private \DateTime $expire;

    public const DATE_FORMAT = 'Y-m-d\TH:i:s\Z';

    public function __construct(string $accessToken, string $expire)
    {
        $this->accessToken = $accessToken;
        $this->expire = \DateTime::createFromFormat(self::DATE_FORMAT, $expire);
    }

    public static function createFromArray(array $data): AccessToken
    {
        return new AccessToken($data["accessToken"], $data["expire"]);
    }

    public static function createFromString(string $str): AccessToken
    {
        try {
            $data = json_decode($str, true, 512, JSON_THROW_ON_ERROR);

            return new AccessToken($data["accessToken"], $data["expire"]);
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
        return $this->accessToken;
    }

    public function getExpireDate(): \DateTime
    {
        return $this->expire;
    }

    /**
     * Return Access accessToken in JSON
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            "accessToken" => $this->accessToken,
            "expire" => $this->expire->format(self::DATE_FORMAT),
        ]);
    }

    public function hasExpired(): bool
    {
        return $this->expire > new \DateTime('now');
    }
}
