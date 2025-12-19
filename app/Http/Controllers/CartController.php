<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // 🛒 Hiển thị giỏ hàng
    public function index()
    {
        if (Auth::check()) {
            // ✅ Lấy ID user hiện tại
            $userId = Auth::id();

            // 🧩 Lấy giỏ hàng từ DB nếu đã đăng nhập
            $cartItems = DB::table('cart')
                ->join('san_pham', 'cart.product_id', '=', 'san_pham.id')
                ->where('cart.user_id', $userId)
                ->select(
                    'san_pham.id as product_id',
                    'san_pham.ten_san_pham',
                    'san_pham.gia',
                    'san_pham.anh',
                    'cart.quantity',
                    'cart.color',
                    'cart.size'
                )
                ->get()
                ->map(function ($item) {
                    return (array) $item; // ép object -> array
                })
                ->toArray();
        } else {
            // 👤 Lấy từ session nếu chưa đăng nhập
            $cartItems = array_values(session('cart', []));
        }

        $coupon = session('coupon');
        return view('cart', compact('cartItems', 'coupon'));
    }

    // 🧩 Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        try {
            // 🧩 Nếu request là JSON (AJAX)
            $data = $request->json()->all();
            if (!empty($data)) {
                $request->merge($data);
            }

            $productId = $request->input('product_id') ?? $request->input('id_san_pham');
            if (!$productId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Thiếu product_id trong request!'
                ], 400);
            }

            $product = Product::findOrFail($productId);
            $quantity = max(1, (int) $request->quantity);
            $color = $request->color ?? $product->mau_sac ?? 'Không rõ';
            $size = $request->size ?? $product->kich_thuoc ?? 'Không rõ';

            // ✅ Xử lý ảnh thống nhất
            $anhData = [];
            if (!empty($product->anh)) {
                if (is_string($product->anh)) {
                    $decoded = json_decode($product->anh, true);
                    if (is_array($decoded)) {
                        $anhData = $decoded;
                    }
                } elseif (is_array($product->anh)) {
                    $anhData = $product->anh;
                }
            }
            if (empty($anhData)) {
                $anhData = ['anh_chinh' => 'images/default.jpg', 'anh_phu' => []];
            }

            // ========================
            // 🛒 Nếu user CHƯA đăng nhập → lưu vào SESSION
            // ========================
            if (!Auth::check()) {
                $cart = session()->get('cart', []);

                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity'] += $quantity;
                } else {
                    $cart[$product->id] = [
                        'product_id' => $product->id,
                        'ten_san_pham' => $product->ten_san_pham,
                        'gia' => $product->gia_khuyen_mai ?? $product->gia,
                        'quantity' => $quantity,
                        'color' => $color,
                        'size' => $size,
                        'anh' => $anhData,
                    ];
                }

                session(['cart' => $cart]);
            } else {
                DB::table('cart')->updateOrInsert(
    [
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'color' => $color,
        'size' => $size,
    ],
    [
        'quantity' => $quantity, // ✅ chỉ lấy đúng số lượng user chọn
        'updated_at' => now(),
        'created_at' => now(),
    ]
);

            }

            return response()->json([
                'status' => 'success',
                'message' => '🎉 Thêm sản phẩm vào giỏ hàng thành công!',
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ Lỗi thêm sản phẩm vào giỏ:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Không thể thêm sản phẩm vào giỏ hàng!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔁 Cập nhật số lượng
public function update(Request $request, $id)
{
    $quantity = (int) $request->input('quantity', 1);

    if (Auth::check()) {
        DB::table('cart')
          ->where('user_id', Auth::id())
          ->where('product_id', $id)
          ->update(['quantity' => $quantity, 'updated_at' => now()]);
    } else {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }
    }

    return response()->json(['success' => true]);
}

// ❌ Xóa sản phẩm
public function remove($id)
{
    if (Auth::check()) {
        DB::table('cart')
            ->where('user_id', Auth::id())
            ->where('product_id', $id)
            ->delete();
    } else {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
    }

    return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
}


    // 🏷 Áp mã giảm giá
    public function applyCoupon(Request $request)
    {
        $code = trim($request->coupon);

        $availableCoupons = [
            'SALE10K' => ['title' => 'Giảm 10K toàn sàn', 'discount' => 10000],
            'SALE20K' => ['title' => 'Giảm 20K đơn từ 249K', 'discount' => 20000],
            'VIP50K' => ['title' => 'Giảm 50K khách VIP', 'discount' => 50000],
        ];

        if (!array_key_exists($code, $availableCoupons)) {
            return back()->withErrors(['coupon' => 'Mã giảm giá không hợp lệ.']);
        }

        session([
            'coupon' => [
                'code' => $code,
                'title' => $availableCoupons[$code]['title'],
                'discount' => $availableCoupons[$code]['discount'],
            ]
        ]);

        return back()->with('success', 'Mã giảm giá đã được áp dụng!');
    }

    // ❌ Xóa mã giảm giá
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Đã xóa mã giảm giá.');
    }

    // 💳 Thanh toán
    public function checkout()
{
    if (Auth::check()) {
        $cartItems = DB::table('cart')
            ->where('user_id', Auth::id())
            ->join('san_pham', 'cart.product_id', '=', 'san_pham.id')
            ->select('san_pham.ten_san_pham', 'san_pham.gia', 'san_pham.gia_khuyen_mai', 'san_pham.anh', 'cart.quantity')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    } else {
        $cartItems = session('cart', []);
    }

    $total = 0;
    foreach ($cartItems as $item) {
        $gia = $item['gia_khuyen_mai'] ?? $item['gia'];
        $total += $gia * $item['quantity'];
    }

    return view('checkout', compact('cartItems', 'total'));
}

}
