<?php

namespace App\Helpers;
use NumberFormatter;

class Currency
{
    public static function format(int $amount, $currency = null)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        if($currency === null){
            $currency = config('app.currency', 'EGP');
        }
        return $formatter->formatCurrency($amount, $currency);
    }
}
