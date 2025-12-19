<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VNPayService;

class VNPayController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function createPayment(Request $request)
    {
        
        $orderId = $request->order_id;
        $amount = $request->amount;

        $url = $this->vnpayService->createPayment($orderId, $amount);
        return redirect($url);
    }

    public function return(Request $request)
{
    $vnp_ResponseCode = $request->vnp_ResponseCode;
    $orderId = $request->vnp_TxnRef;

    $order = \App\Models\Order::find($orderId);

    if ($vnp_ResponseCode == "00" && $order) {
        $order->update(['status' => 'paid']);
        return redirect()->route('order.confirmation', ['id' => $order->id])
            ->with('success', 'Thanh toán VNPay thành công!');
    } else {
        if ($order) {
            $order->update(['status' => 'failed']);
        }
        return redirect()->route('checkout')
            ->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy!');
    }
}

}
