<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //$gateway = new Braintree\Gateway([
    //    'environment' => 'sandbox',
    //    'merchantId' => env('merchantId'),
    //    'publicKey' => env('publicKey'),
    //    'privateKey' => env('privateKey')
    //]);

    //$aCustomerId = "mjczz";
    //$clientToken = $gateway->clientToken()->generate([
        //"customerId" => $aCustomerId
    //]);

    //return $clientToken;

    return view('welcome');
});

Route::get('/b', function () {
    return view('btree');
});

Route::post('checkout', function(Request $request) {
    // 测试信用卡号 4111111111111111
    $gateway = new Braintree\Gateway([
        'environment' => 'sandbox',
        'merchantId' => env('merchantId'),
        'publicKey' => env('publicKey'),
        'privateKey' => env('privateKey')
    ]);

    $result = $gateway->transaction()->sale([
        'amount' => '13.00',
        'paymentMethodNonce' => $request['paymentMethodNonce'],
        //'deviceData' => $deviceDataFromTheClient,
        'options' => [
            'submitForSettlement' => True
        ]
    ]);

    return [
        'success' => $result->success
    ];
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
