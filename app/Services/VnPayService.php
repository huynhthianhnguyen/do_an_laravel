<?php

namespace App\Services;

class VNPayService
{
    public function createPayment($orderId, $amount)
    {
        $vnp_Url = env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnp_ReturnUrl = env('VNP_RETURN_URL');
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = trim(env('VNP_HASH_SECRET'));

        $vnp_TxnRef = (string) $orderId;
        $vnp_OrderInfo = "Thanh toán đơn hàng #$orderId";
        $vnp_Amount = (int)($amount * 100);
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();

        // B1: Chuẩn bị dữ liệu
        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_TmnCode"   => $vnp_TmnCode,
            "vnp_Amount"    => $vnp_Amount,
            "vnp_Command"   => "pay",
            "vnp_CreateDate"=> date('YmdHis'),
            "vnp_CurrCode"  => "VND",
            "vnp_IpAddr"    => $vnp_IpAddr,
            "vnp_Locale"    => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "fashion",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef"    => $vnp_TxnRef,
        ];

        // B2: Sắp xếp A-Z
        ksort($inputData);

        // B3: Tạo chuỗi hashdata (KHÔNG dùng http_build_query)
        $hashData = urldecode(http_build_query($inputData, '', '&'));

        // B4: Sinh chữ ký
        $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // B5: Tạo URL thanh toán
        $query = http_build_query($inputData);
        $vnp_Url = $vnp_Url . '?' . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

        return $vnp_Url;
    }
}
