<?php

namespace App\Services;

class MomoService
{
    public function createPayment($orderId, $amount)
    {
        $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');

        $orderInfo = "Thanh toán đơn hàng #$orderId";
        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.notify');

        $requestId = (string) time(); // dùng requestId riêng
        $orderIdMomo = "ORDER" . $orderId . "_" . time(); // đặt tên khác để không ghi đè

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=&ipnUrl=$ipnUrl&orderId=$orderIdMomo&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Olivine Fashion",
            'storeId' => "OlivineStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderIdMomo,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => 'captureWallet',
            'signature' => $signature,
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        // ✅ Kiểm tra phản hồi hợp lệ
        if (isset($response['payUrl'])) {
            return $response;
        } else {
            \Log::error('Momo createPayment failed', ['response' => $response]);
            return null;
        }
    }
}
