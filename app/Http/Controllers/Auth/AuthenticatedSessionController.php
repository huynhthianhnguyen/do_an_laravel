<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị trang đăng nhập.
     */
    public function create(): View
    {
        return view('auth.login');
    }

  public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    // 🔥 SỬA LỖI: Refresh lại user để lấy đúng utype
    Auth::user()->refresh();

    $request->session()->regenerate();
        $sessionCart = session('cart', []);

        if (!empty($sessionCart)) {
            foreach ($sessionCart as $item) {
                DB::transaction(function () use ($item) {
                    $exists = DB::table('cart')
                        ->where('user_id', Auth::id())
                        ->where('product_id', $item['product_id'])
                        ->where('color', $item['color'] ?? null)
                        ->where('size', $item['size'] ?? null)
                        ->first();

                    if ($exists) {
                        // Nếu sản phẩm đã tồn tại trong DB → tăng số lượng
                        DB::table('cart')
                            ->where('id', $exists->id)
                            ->increment('quantity', $item['quantity']);
                    } else {
                        // Nếu chưa có → thêm mới
                        DB::table('cart')->insert([
                            'user_id' => Auth::id(),
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'] ?? 1,
                            'color' => $item['color'] ?? null,
                            'size' => $item['size'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                });
            }

            // ✅ Xóa giỏ hàng session sau khi gộp vào DB
            session()->forget('cart');
        }
 if (Auth::user()->utype === 'ADM') {
        return redirect()->route('admin.dashboard');
    }

    return redirect('/');
}

    /**
     * Đăng xuất tài khoản.
     */
    public function destroy(Request $request): RedirectResponse
{
    // 🧩 Nếu user đang đăng nhập, lưu giỏ hàng từ DB sang session trước khi logout
    if (Auth::check()) {
        $userId = Auth::id();

        // Lấy giỏ hàng từ DB
        $cartItems = DB::table('cart')->where('user_id', $userId)->get();
        $sessionCart = [];

        foreach ($cartItems as $item) {
            $sessionCart[$item->product_id] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'color' => $item->color,
                'size' => $item->size,
            ];
        }

        // ✅ Lưu lại vào session (để khi đăng xuất vẫn còn giỏ hàng)
        session(['cart' => $sessionCart]);
    }

    // 🚪 Thực hiện đăng xuất
    Auth::guard('web')->logout();

    // 🔐 Reset lại session token để bảo mật
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // ✅ Chuyển hướng về trang chủ
    return redirect('/');
}

}
