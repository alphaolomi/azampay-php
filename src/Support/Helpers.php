<?php

namespace Alphaolomi\Azampay\Support;

/**
 * @author Alpha Olomi
 * @version 1.0.0
 */
class Helpers
{
    /**
     * Cleans the mobile number to remove any whitespace or dashes
     *
     * @param  string  $mobileNumber
     * @return string
     */
    public static function cleanMobileNumber(string $phoneNumber)
    {
        $mobileNumber = $phoneNumber;
        $mobileNumber = str_replace(' ', '', $mobileNumber);
        $mobileNumber = str_replace('-', '', $mobileNumber);
        // trim
        $mobileNumber = trim($mobileNumber);

        if (strlen($mobileNumber) < 9 || strlen($mobileNumber) > 12) {
            throw new \RuntimeException('Invalid mobile number');
        }
        if (strlen($mobileNumber) == 9 && $mobileNumber[0] != '0') {
            $mobileNumber = "255{$mobileNumber}";
        }
        if (strlen($mobileNumber) == 10 && $mobileNumber[0] == '0') {
            $mobileNumber = substr_replace($mobileNumber, '255', 0, 1);
        }
        // fixme: add return
        return $mobileNumber;
    }

    /**
     * Clean the amount to remove any whitespace or commas
     *
     * @param  string  $amount
     * @return string
     */
    public static function cleanAmount($amount)
    {
        $amount = trim($amount);
        $amount = str_replace(' ', '', $amount);
        $amount = str_replace(',', '', $amount);

        return $amount;
    }
}
