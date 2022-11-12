<?php

use Alphaolomi\Azampay\AccessToken;


it('can instantiate access Token', function () {
    $accessToken = new AccessToken('token', '2022-11-03T14:12:40Z');
    expect($accessToken->getToken())->toBe('token');
    expect($accessToken->getExpireDate()->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

// it can create from json string
it('can create from json string', function () {
    $accessToken = AccessToken::create('{"token":"token","expireDate":"2022-11-03T14:12:40Z"}');
    expect($accessToken->getToken())->toBe('token');
    expect($accessToken->getExpireDate()->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

// it can create from array

it('can create from array', function () {
    $accessToken = AccessToken::create(['token' => 'token', 'expireDate' => '2022-11-03T14:12:40Z']);
    expect($accessToken->getToken())->toBe('token');
    expect($accessToken->getExpireDate()->format('Y-m-d\TH:i:s\Z'))->toBe('2022-11-03T14:12:40Z');
});

// it can cast __toString

it('can cast __toString', function () {
    $accessToken = AccessToken::create(['token' => 'token', 'expireDate' => '2022-11-03T14:12:40Z']);
    expect((string) $accessToken)->toBe('{"token":"token","expireDate":"2022-11-03T14:12:40Z"}');
});


// it can check if hasExpired

it('can check if hasExpired', function () {
    $accessToken = AccessToken::create(['token' => 'token', 'expireDate' => '2022-11-03T14:12:40Z']);
    expect($accessToken->hasExpired())->toBeFalse();
});

