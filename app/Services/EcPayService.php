<?php

namespace App\Services;

use App\Models\Order;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;

require __DIR__ . '/../../vendor/autoload.php';

class EcPayService
{
    public function createPaymentForm(Order $order)
    {
        $factory = new Factory([
            'hashKey' => env('HASH_KEY'),
            'hashIv' => env('HASH_IV'),
        ]);

        $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

        $input = [
            'MerchantID' => env('MERCHANT_ID'),
            'MerchantTradeNo' => $order->order_id,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => $order->total,
            'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
            'ItemName' => 'hanShop',
            'ChoosePayment' => 'ALL',
            'EncryptType' => 1,

            'ReturnURL' => env('RETURN_URL'),
            'ClientBackURL' => env('CLIENT_BACK_URL')
        ];
        $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

        $htmlForm = $autoSubmitFormService->generate($input, $action);

        return $htmlForm;
    }
}