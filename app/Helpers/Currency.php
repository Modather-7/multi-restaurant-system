<?php

namespace App\Helpers;
use NumberFormatter;

class Currency
{
    public static function format($amount, $currency = null)
    {
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        if($currency === null){
            $currency = config('app.currency', 'EGP');
        }
        return $formatter->formatCurrency($amount, $currency);
    }
}
