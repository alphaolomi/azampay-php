<?php

use Alphaolomi\Azampay\Support\Helpers;

//
// Number
//
test('cleanMobileNumber helper', function ($number) {
    $cleanNumber = Helpers::cleanMobileNumber($number);
    expect($cleanNumber)->toBeString();
})->with([
    '747991498',
    '0747991498',
    '255747991498',
    '255 74 799 1498',
    '255-74-799-1498',
]);


test('throws if bad number', function ($number) {
    Helpers::cleanMobileNumber($number);
})->with([
    '47991498',
    '3255747991498',
])->throws(RuntimeException::class);

//
// Amount
//

test('cleanAmount helper', function ($number) {
    $cleanNumber = Helpers::cleanAmount($number);
    expect($cleanNumber)->toBeString();
})->with([
    ' 40000  ', // no prefix/suffix spaces
    '40,000', // no commas
    '4 799 1498', // no spaces
]);
