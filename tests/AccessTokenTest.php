<?php

use Alphaolomi\Azampay\AccessToken;


it('can instantiate access Token', function () {
    $accessToken = new AccessToken(
        accessToken: 'U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+JytadEaObdtjuukmJqzQ2pcf',
        expire: '2022-11-03T14:12:40Z'
    );
    expect($accessToken->getToken())->toBe('U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+JytadEaObdtjuukmJqzQ2pcf');
    expect($accessToken->getExpireDate()
        ->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});


it('will return if at is given', function () {
    $_accessToken = AccessToken::create('{"accessToken":"U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+Jytad","expire":"2022-11-03T14:12:40Z"}');
    $accessToken=  AccessToken::create($_accessToken);
    expect($accessToken->getToken())->toBeString();
    expect($accessToken->getExpireDate()
        ->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

it('can create from json string', function () {
    $accessToken = AccessToken::create('{"accessToken":"U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+Jytad","expire":"2022-11-03T14:12:40Z"}');
    expect($accessToken->getToken())->toBeString();
    expect($accessToken->getExpireDate()
        ->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

it('will throw if creating from bad json string', function () {
    AccessToken::create('{"accessToken:"U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+Jytad","expire":"2022-11-03T14:12:40Z"}');
})->throws(InvalidArgumentException::class);

it('can create from array', function () {
    $accessToken = AccessToken::create([
        'accessToken' => 'U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+JytadEaObdtjuukmJqzQ2pcfqpnHZbpn8zi+SLe53bOrrm6h5dhLOP4BTjJknbbnf9iVDBvJFh',
        'expire' => '2022-11-03T14:12:40Z'
    ]);
    expect($accessToken->getToken())->toBeString();
    expect($accessToken->getExpireDate()
        ->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

it('can cast __toString', function () {
    $accessToken = AccessToken::create(['accessToken' => 'token', 'expire' => '2022-11-03T14:12:40Z']);
    expect((string) $accessToken)->toBe('{"accessToken":"token","expire":"2022-11-03T14:12:40Z"}');
});


it('can check if hasExpired true', function () {
    $accessToken = AccessToken::create(['accessToken' => 'token', 'expire' => '2021-11-03T14:12:40Z']);
    expect($accessToken->hasExpired())->toBeFalse();
});


it('can check if hasExpired false', function () {
    $accessToken = AccessToken::create(['accessToken' => 'token', 'expire' => '2023-11-03T14:12:40Z']);
    expect($accessToken->hasExpired())->toBeTrue();
});
