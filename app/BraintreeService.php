<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/10/19
 * Time: 22:49
 */
namespace App;

class BraintreeService
{
    public static function getGateway()
    {
        return new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => env('merchantId'),
            'publicKey' => env('publicKey'),
            'privateKey' => env('privateKey')
        ]);
    }

    public static function getClientToken()
    {
        return (self::getGateway())->clientToken()->generate();
    }
}
