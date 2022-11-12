<?php

namespace Alphaolomi\Azampay\Support;

/**
 * @author Alpha Olomi
 */
class Helper
{
    /**
     * Cleans the mobile number to remove any whitespace or dashes
     *
     * @param  string  $mobileNumber
     * @return string
     */
    public static function cleanMobileNumber(string $mobileNumber)
    {
        $mobileNumber = preg_replace('/[^0-9]/', '', $mobileNumber);

        if (strlen($mobileNumber) < 9 || strlen($mobileNumber) > 12) {
            throw new \RuntimeException('Invalid mobile number');
        }
        if (strlen($mobileNumber) == 9 && $mobileNumber[0] != '0') {
            $mobileNumber = "255{$mobileNumber}";
        } elseif (strlen($mobileNumber) == 10 && $mobileNumber[0] == '0') {
            $mobileNumber = str_replace('0', '255', $mobileNumber, 1);
        }
        // fixme: add return
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
