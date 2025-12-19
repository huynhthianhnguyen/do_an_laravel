<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MomoService;
use App\Models\Order;

class MomoController extends Controller
{
    protected $momoService;

    public function __construct(MomoService $momoService)
    {
        $this->momoService = $momoService;
    }

    /**
     * Tạo thanh toán Momo và chuyển hướng người dùng sang trang thanh toán
     */
    public function createPayment(Request $request)
    {
        $orderId = $request->order_id;
        $amount = $request->amount;

        $result = $this->momoService->createPayment($orderId, $amount);

        if (isset($result['payUrl'])) {
            return redirect($result['payUrl']);
        }

        return back()->with('error', 'Không thể tạo thanh toán MoMo. Vui lòng thử lại!');
    }

    /**
     * Khi người dùng thanh toán xong và quay lại website
     */
    public function return(Request $request)
    {
        if ($request->resultCode == 0) {
            // Thanh toán thành công
            // Bạn có thể cập nhật trạng thái đơn hàng tại đây
            return redirect()->route('order.confirmation')->with('success', 'Thanh toán MoMo thành công!');
        } else {
            return redirect()->route('checkout')->with('error', 'Thanh toán MoMo thất bại.');
        }
    }

    /**
     * Nhận thông báo từ MoMo (IPN)
     */
    public function notify(Request $request)
    {
        // Đây là nơi MoMo gửi thông báo trạng thái (thường dùng để tự động cập nhật trạng thái đơn hàng)
        \Log::info('MoMo Notify:', $request->all());
        return response()->json(['message' => 'success']);
    }
}
