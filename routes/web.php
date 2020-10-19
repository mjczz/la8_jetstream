<?php

use App\BraintreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    return view('welcome');
});


// 信用卡支付
Route::get('/card_pay', function () {
    $clientToken = BraintreeService::getClientToken();

    return view('btree', compact('clientToken'));
});

// 信用卡发起交易
Route::post('checkout', function(Request $request) {
    // 测试信用卡号 4111111111111111
    $gateway = BraintreeService::getGateway();

    $result = $gateway->transaction()->sale([
        'amount' => $request['amount'] ?? 10,
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

// paypal支付
Route::get('/p_pay', function () {
    $clientToken = BraintreeService::getClientToken();

    return view('paypal', compact('clientToken'));
});

// paypal发起交易
Route::post('paypal_submit', function(Request $request) {

    $data = $request->get('payload');
    DB::table('paypay_pay_params')->insert([
        'params' => json_encode($data, JSON_UNESCAPED_SLASHES),
    ]);

    $json = '{"nonce":"273aea70-92c9-05db-5592-b24b50fc556c","details":{"email":"mjczz1991@gmail.com","firstName":"祖志","lastName":"曹","payerId":"HZAH486N8E96N","shippingAddress":{"recipientName":"Scruff McGruff","line1":"1234 Main St.","line2":"Unit 1","city":"Chicago","state":"IL","postalCode":"60652","countryCode":"US"},"countryCode":"C2"},"type":"PayPalAccount"}';

    $param = json_decode($json, 1);

    // 测试信用卡号 4111111111111111
    $gateway = BraintreeService::getGateway();

    $result = $gateway->transaction()->sale([
        'amount' => $request['amount'] ?? 0.01,
        'paymentMethodNonce' => $request['nonce'],
        //'deviceData' => $request['device_data'],
        //'orderId' => $request["order_id"] ?? date('Y-m-d').rand(1,100).time(), //Mapped to PayPal Invoice Number
        'options' => [
            'submitForSettlement' => True,
            'paypal' => [
                //'customField' => $_POST["PayPal custom field"],
                //'description' => $_POST["Description for PayPal email receipt"],
            ],
        ],
    ]);
    if ($result->success) {
        print_r("Success ID: " . $result->transaction->id);
        return [
            'success' => $result->success
        ];
    } else {
        print_r("Error Message: " . $result->message);
        return [
            'success' => $result->success,
            'msg' => $result->message
        ];
    }
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
