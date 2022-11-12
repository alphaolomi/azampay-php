<?php

use Alphaolomi\Azampay\Support\Helpers;

test('cleanMobileNumber helper', function ($number) {
    $cleanNumber = Helpers::cleanMobileNumber($number);
    expect($cleanNumber)->toBeString();
})->with([
    '0747991498',
    '255747991498',
    '255 74 799 1498',
    '255-74-799-1498',
]);
