<?php

use Alphaolomi\Azampay\AccessToken;
use Alphaolomi\Azampay\Azampay;

test('Azam pay', function () {
    $azampay = new Azampay([
        'appName' => 'Abc demo',
        'clientId' => 'd69c2a0a-dfe7-4403-9829-bb54e617df3a',
        'clientSecret' => 'Jz+AGaPTMbRcwQztfm4911Xx7tY5lP6HvHYiH7GarbNVtz3X/VIQ6TrJ79AkWLOS/Uuo1S7xrOxv4Cd9sVxAtun0CNVVvHB3FnKEIb/unrx7We0vDJeZs3jHFEtMSDrOHft3i6tKDEke23LoLVm9dSJPAwMXvVCdq8a1VNiSlTd/ttYXEt7gJ9c2rVatjBIu9sX/ezsTokiPX2bIVyO0dBbSlIldBhloYsfUqG5nSSsJupTBLSYIFm0BOM94hW4jo9dIri1ghNqqUs013OcJNHBlE6+IQhBMOa3Dx9zWLE0XC+yktkwFvw2gqD5IAro1G5seQoKbdHxK1A8nY0426mVySuHAtEFcbZ0HpWEpt4Lau2CAFOFAOwPDK9bN46DMKG2FnsO/BFhT/pwjWYki0QPquTpADK6SVF/9ghdFLObbI0vL1j9Us54wFy4mSBAmzV8G47tn5RJbURk2CcMoW0ez94A/jsAher32wBUlB+GAKbgDniHDpaa7bnCXBY/+i/rFIJanXiMvMV/n6L0qHfKKnmP+IbSFM/r8IYUtwFNONPqROdBGIX/2VFBAP6QwiLp5W7FuxILLhsiZNmpzTGBTqe8Aa8uKNH1qJMkEbfENuwB4BivGRTMsAotNhkJfJBZteO7K7HI7lWjE4o48SkbcQLVbut+97K2J3sUoSe8=',
        'environment' => 'sandbox',
    ]);

    expect($azampay)->toBeInstanceOf(Azampay::class);
//     expect($azampay->generateToken())->toBeInstanceOf(AccessToken::class);
     expect($azampay->generateToken())->dd();

});
