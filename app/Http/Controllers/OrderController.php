<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmationMail;
use App\Services\MomoService;
use App\Services\VNPayService;

class OrderController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'name'            => 'required|string',
        'phone'           => 'required|string',
        'address'         => 'required|string',
          'email' => 'required|email',
        'payment_method'  => 'required|string',
    ]);

    // ✅ 1. Lấy giỏ hàng
    if (auth()->check()) {
        $cart = DB::table('cart')
            ->where('user_id', auth()->id())
            ->join('san_pham', 'cart.product_id', '=', 'san_pham.id')
            ->select(
                'san_pham.id as product_id',
                'san_pham.ten_san_pham',
                'san_pham.gia',
                'san_pham.gia_khuyen_mai',
                'cart.quantity',
                'cart.color',
                'cart.size',
            )
            ->get();
    } else {
        $cart = collect(session('cart', []));
    }

    if ($cart->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống!');
    }

    // ✅ 2. Tính tổng tiền trước khi tạo đơn
    // ✅ 2. Tính tổng tiền và VAT
$subtotal = 0;
foreach ($cart as $item) {
    $gia = $item->gia_khuyen_mai ?: $item->gia ?: 0;
    $quantity = $item->quantity ?: 1;
    $subtotal += $gia * $quantity;
}

if ($subtotal <= 0) {
    return back()->with('error', 'Không thể tạo đơn hàng vì tổng tiền bằng 0.');
}

// ✅ 3. Tính VAT (10%) và phí vận chuyển
$vat = $subtotal * 0.1;
$shipping_fee = 0;

// ✅ 4. Tổng cộng
$total = $subtotal + $vat + $shipping_fee;

// ✅ 5. Tạo đơn hàng
$order = Order::create([
    'user_id'        => auth()->id(),
    'name'           => $request->name,
    'phone'          => $request->phone,
    'address'        => $request->address,
    'subtotal'       => $subtotal,
    'vat'            => $vat,
    'shipping_fee'   => $shipping_fee,
    'total'          => $total,
    'payment_method' => $request->payment_method,
    'status'         => 'pending',
]);
    // ✅ 4. Lưu chi tiết sản phẩm
    foreach ($cart as $item) {
        $gia = $item->gia_khuyen_mai ?: $item->gia ?: 0;
        $quantity = $item->quantity ?: 1;

        DB::table('order_items')->insert([
            'order_id'     => $order->id,
            'product_id'   => $item->product_id ?? null,
            'ten_san_pham' => $item->ten_san_pham ?? 'Sản phẩm không tên',
            'quantity'     => $quantity,
            'gia'          => $gia,
            'tong_tien'    => $gia * $quantity,
            'color'        => $item->color ?? null,
            'size'         => $item->size ?? null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
Mail::to($request->email)->send(new OrderConfirmationMail($order));
    // ✅ 5. Xóa giỏ hàng
    if (auth()->check()) {
        DB::table('cart')->where('user_id', auth()->id())->delete();
    } else {
        session()->forget('cart');
    }

    // ✅ 6. Thanh toán
    if ($request->payment_method === 'momo') {
        $momo = new MomoService();
        $payment = $momo->createPayment($order->id, $total);

        if (is_array($payment) && isset($payment['payUrl'])) {
            return redirect($payment['payUrl']);
        } else {
            \Log::error('Momo payment failed', ['response' => $payment]);
            return back()->with('error', 'Không thể tạo thanh toán MoMo.');
        }
    }

    if ($request->payment_method === 'vnpay') {
        $vnpay = new VNPayService();
        $paymentUrl = $vnpay->createPayment($order->id, $total);

        if ($paymentUrl) {
            return redirect($paymentUrl);
        } else {
            \Log::error('VNPay payment failed', ['response' => $paymentUrl]);
            return back()->with('error', 'Không thể tạo thanh toán VNPay.');
        }
    }

    // ✅ 7. Thanh toán COD
    return redirect()->route('order.confirmation', ['id' => $order->id])
        ->with('success', 'Đơn hàng của bạn đã được ghi nhận!');
}

    // ✅ 8. Trang xác nhận đơn hàng
    public function orderConfirmation($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('order-confirmation', compact('order'));
    }
    // ===============================
// ⭐ 9. Danh sách đơn hàng của user
// ===============================
public function myOrders()
{
    $orders = Order::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('my-orders', compact('orders'));
}

// ===============================
// ⭐ 10. Chi tiết đơn hàng
// ===============================
public function orderDetail($id)
{
    $order = Order::where('user_id', auth()->id())
                  ->with('items')
                  ->findOrFail($id);

    return view('order-detail', compact('order'));
}
public function cancel(Order $order)
{
    // Kiểm tra quyền sở hữu đơn hàng
    if ($order->user_id != auth()->id()) {
        abort(403);
    }

    // Chỉ cho hủy nếu đơn hàng đang xử lý
    if (!in_array($order->status, ['pending', 'processing'])) {
        return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
    }

    $order->status = 'cancelled';
    $order->save();

    return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
}

}
