<?php

use Alphaolomi\Azampay\AccessToken;
use Alphaolomi\Azampay\Azampay;
use GuzzleHttp\Client;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

it('can cant instantiate without clientSecret', function () {
    expect(new Azampay([
        'appName' => 'Abc demo',
        'clientId' => 'd69c2a0a-dfe7-4403-9829-bb54e617df3a',
        'environment' => 'sandbox',
    ]))->toBeInstanceOf(Azampay::class);
})->throws(InvalidArgumentException::class);


it('can cant instantiate without clientId', function () {
    expect(new Azampay([
        'appName' => 'Abc demo',
        'clientSecret' => 'Jz+AGaPTMbRcwQztfm4911Xx7tY5lP6HvHYiH7GarbNVtz3X/VIQ6TrJ79AkWLOS/Uuo1S7xrOxv4Cd9sVxAtun0CNVVvHB3FnKEIb/unrx7We0vDJeZs3jHFEtMSDrOHft3i6tKDEke23LoLVm9dSJPAwMXvVCdq8a1VNiSlTd/ttYXEt7gJ9c2rVatjBIu9sX/ezsTokiPX2bIVyO0dBbSlIldBhloYsfUqG5nSSsJupTBLSYIFm0BOM94hW4jo9dIri1ghNqqUs013OcJNHBlE6+IQhBMOa3Dx9zWLE0XC+yktkwFvw2gqD5IAro1G5seQoKbdHxK1A8nY0426mVySuHAtEFcbZ0HpWEpt4Lau2CAFOFAOwPDK9bN46DMKG2FnsO/BFhT/pwjWYki0QPquTpADK6SVF/9ghdFLObbI0vL1j9Us54wFy4mSBAmzV8G47tn5RJbURk2CcMoW0ez94A/jsAher32wBUlB+GAKbgDniHDpaa7bnCXBY/+i/rFIJanXiMvMV/n6L0qHfKKnmP+IbSFM/r8IYUtwFNONPqROdBGIX/2VFBAP6QwiLp5W7FuxILLhsiZNmpzTGBTqe8Aa8uKNH1qJMkEbfENuwB4BivGRTMsAotNhkJfJBZteO7K7HI7lWjE4o48SkbcQLVbut+97K2J3sUoSe8=',
        'environment' => 'sandbox',
    ]))->toBeInstanceOf(Azampay::class);
})->throws(InvalidArgumentException::class);



it('can cant instantiate without appName', function () {
    expect(new Azampay([
        'clientId' => 'd69c2a0a-dfe7-4403-9829-bb54e617df3a',
        'clientSecret' => 'Jz+AGaPTMbRcwQztfm4911Xx7tY5lP6HvHYiH7GarbNVtz3X/VIQ6TrJ79AkWLOS/Uuo1S7xrOxv4Cd9sVxAtun0CNVVvHB3FnKEIb/unrx7We0vDJeZs3jHFEtMSDrOHft3i6tKDEke23LoLVm9dSJPAwMXvVCdq8a1VNiSlTd/ttYXEt7gJ9c2rVatjBIu9sX/ezsTokiPX2bIVyO0dBbSlIldBhloYsfUqG5nSSsJupTBLSYIFm0BOM94hW4jo9dIri1ghNqqUs013OcJNHBlE6+IQhBMOa3Dx9zWLE0XC+yktkwFvw2gqD5IAro1G5seQoKbdHxK1A8nY0426mVySuHAtEFcbZ0HpWEpt4Lau2CAFOFAOwPDK9bN46DMKG2FnsO/BFhT/pwjWYki0QPquTpADK6SVF/9ghdFLObbI0vL1j9Us54wFy4mSBAmzV8G47tn5RJbURk2CcMoW0ez94A/jsAher32wBUlB+GAKbgDniHDpaa7bnCXBY/+i/rFIJanXiMvMV/n6L0qHfKKnmP+IbSFM/r8IYUtwFNONPqROdBGIX/2VFBAP6QwiLp5W7FuxILLhsiZNmpzTGBTqe8Aa8uKNH1qJMkEbfENuwB4BivGRTMsAotNhkJfJBZteO7K7HI7lWjE4o48SkbcQLVbut+97K2J3sUoSe8=',
        'environment' => 'sandbox',
    ]))->toBeInstanceOf(Azampay::class);
})->throws(InvalidArgumentException::class);



it('can instantiate without user http client', function () {
    expect(new Azampay([
        'appName' => 'Abc demo',
        'clientId' => 'd69c2a0a-dfe7-4403-9829-bb54e617df3a',
        'clientSecret' => 'Jz+AGaPTMbRcwQztfm4911Xx7tY5lP6HvHYiH7GarbNVtz3X/VIQ6TrJ79AkWLOS/Uuo1S7xrOxv4Cd9sVxAtun0CNVVvHB3FnKEIb/unrx7We0vDJeZs3jHFEtMSDrOHft3i6tKDEke23LoLVm9dSJPAwMXvVCdq8a1VNiSlTd/ttYXEt7gJ9c2rVatjBIu9sX/ezsTokiPX2bIVyO0dBbSlIldBhloYsfUqG5nSSsJupTBLSYIFm0BOM94hW4jo9dIri1ghNqqUs013OcJNHBlE6+IQhBMOa3Dx9zWLE0XC+yktkwFvw2gqD5IAro1G5seQoKbdHxK1A8nY0426mVySuHAtEFcbZ0HpWEpt4Lau2CAFOFAOwPDK9bN46DMKG2FnsO/BFhT/pwjWYki0QPquTpADK6SVF/9ghdFLObbI0vL1j9Us54wFy4mSBAmzV8G47tn5RJbURk2CcMoW0ez94A/jsAher32wBUlB+GAKbgDniHDpaa7bnCXBY/+i/rFIJanXiMvMV/n6L0qHfKKnmP+IbSFM/r8IYUtwFNONPqROdBGIX/2VFBAP6QwiLp5W7FuxILLhsiZNmpzTGBTqe8Aa8uKNH1qJMkEbfENuwB4BivGRTMsAotNhkJfJBZteO7K7HI7lWjE4o48SkbcQLVbut+97K2J3sUoSe8=',
        'environment' => 'sandbox',
    ]))->toBeInstanceOf(Azampay::class);
});





beforeEach(function () {
    /** @var MockHandler */
    $this->mock = new MockHandler([]);

    /** @var HandlerStack */
    $this->handlerStack = HandlerStack::create($this->mock);

    /** @var Client */
    $httpClient = new Client(['handler' => $this->handlerStack]);

    /** @var Azampay */
    $this->azampay = new Azampay([
        'appName' => 'Abc demo',
        'clientId' => 'd69c2a0a-dfe7-4403-9829-bb54e617df3a',
        'clientSecret' => 'Jz+AGaPTMbRcwQztfm4911Xx7tY5lP6HvHYiH7GarbNVtz3X/VIQ6TrJ79AkWLOS/Uuo1S7xrOxv4Cd9sVxAtun0CNVVvHB3FnKEIb/unrx7We0vDJeZs3jHFEtMSDrOHft3i6tKDEke23LoLVm9dSJPAwMXvVCdq8a1VNiSlTd/ttYXEt7gJ9c2rVatjBIu9sX/ezsTokiPX2bIVyO0dBbSlIldBhloYsfUqG5nSSsJupTBLSYIFm0BOM94hW4jo9dIri1ghNqqUs013OcJNHBlE6+IQhBMOa3Dx9zWLE0XC+yktkwFvw2gqD5IAro1G5seQoKbdHxK1A8nY0426mVySuHAtEFcbZ0HpWEpt4Lau2CAFOFAOwPDK9bN46DMKG2FnsO/BFhT/pwjWYki0QPquTpADK6SVF/9ghdFLObbI0vL1j9Us54wFy4mSBAmzV8G47tn5RJbURk2CcMoW0ez94A/jsAher32wBUlB+GAKbgDniHDpaa7bnCXBY/+i/rFIJanXiMvMV/n6L0qHfKKnmP+IbSFM/r8IYUtwFNONPqROdBGIX/2VFBAP6QwiLp5W7FuxILLhsiZNmpzTGBTqe8Aa8uKNH1qJMkEbfENuwB4BivGRTMsAotNhkJfJBZteO7K7HI7lWjE4o48SkbcQLVbut+97K2J3sUoSe8=',
        'environment' => 'sandbox',
    ], $httpClient);
});



it('can instantiate proper classes', function () {
    expect($this->azampay)->toBeInstanceOf(Azampay::class);
});

it('can generate token', function () {
    $this->mock->reset();
    $this->mock->append(stub_response('generate_token'));

    $token = $this->azampay->generateToken();

    expect($token)->toBeTruthy();
    expect($token)->toBeInstanceOf(AccessToken::class);
});

it('throw if 423 generate token', function () {
    $this->mock->reset();
    $this->mock->append(
        new GuzzleHttp\Psr7\Response(
            status: 423,
            headers: [],
            body: null
        )
    );

    $this->azampay->generateToken();
})->throws(RuntimeException::class);




it('can use mobile checkout with user\'s accessToken', function () {
    $this->mock->reset();

    $this->mock->append(stub_response('mobile_checkout'));

    $accessToken = AccessToken::create([
        'accessToken' => 'U2FsdGVkX1+q/NDwjNHcDpubTVE/wWT+JytadEaObdtjuukmJqzQ2pcfqpnHZbpn8zi+SLe53bOrrm6h5dhLOP4BTjJknbbnf9iVDBvJFh',
        'expire' => '2023-11-03T14:12:40Z',
    ]);

    $res = $this->azampay->mobileCheckout([
        "referenceId" => rand(1000, 9999),
        "accountNumber" => "255747991498",
        "amount" => "5000",
        "provider" => "Airtel",
        "additionalProperties" => [
            "name" => "Jane Doe",
            "email" => "jane.doe@gmail.com",
        ],
    ], $accessToken);

    expect($res)->toBeTruthy();
});

it('can use mobile checkout', function () {
    $this->mock->reset();
    $this->mock->append(stub_response('generate_token'));
    $this->mock->append(stub_response('mobile_checkout'));

    $res = $this->azampay->mobileCheckout([
        "referenceId" => rand(1000, 9999),
        "accountNumber" => "255747991498",
        "amount" => "5000",
        "provider" => "Airtel",
        "additionalProperties" => [
            "name" => "Jane Doe",
            "email" => "jane.doe@gmail.com",
        ],
    ]);

    expect($res)->toBeTruthy();
});



it('can use mobile checkout with saved AT', function () {
    $this->mock->reset();
    $this->mock->append(stub_response('generate_token'));
    $this->mock->append(stub_response('mobile_checkout'));
    $this->mock->append(stub_response('mobile_checkout'));

    $res = $this->azampay->mobileCheckout([
        "referenceId" => rand(1000, 9999),
        "accountNumber" => "255747991498",
        "amount" => "5000",
        "provider" => "Airtel",
        "additionalProperties" => [
            "name" => "Jane Doe",
            "email" => "jane.doe@gmail.com",
        ],
    ]);
    $res2 = $this->azampay->mobileCheckout([
        "referenceId" => rand(1000, 9999),
        "accountNumber" => "255757991498",
        "amount" => "5000",
        "provider" => "Airtel",
        "additionalProperties" => [
            "name" => "Jane Doe",
            "email" => "jane.doe@gmail.com",
        ],
    ]);

    expect($res)->toBeTruthy();
    expect($res2)->toBeTruthy();
});


it('can use bankCheckout checkout', function () {
    $this->mock->reset();
    $this->mock->append(stub_response('generate_token'));
    $this->mock->append(stub_response('bank_checkout'));

    $res = $this->azampay->bankCheckout([
        "amount" => "4000",
        "merchantAccountNumber" => "1234747991498",
        "merchantMobileNumber" => "255747991498",
        "merchantName" => "Abc demo",
        "otp" => "1025",
        "provider" => "CRDB",
        "referenceId" => rand(1000, 9999),
        "additionalProperties" => [
            "name" => "Jane Doe",
            "email" => "jane.doe@gmail.com",
        ],

    ]);

    expect($res)->toBeTruthy();
});
