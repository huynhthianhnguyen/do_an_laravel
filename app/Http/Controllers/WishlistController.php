<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist; 
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // 💕 Hiển thị danh sách yêu thích
   public function index()
{
    if (Auth::check()) {
        // 🧡 Người dùng đã đăng nhập → lấy từ database
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->join('san_pham', 'wishlist.product_id', '=', 'san_pham.id')
            ->select('san_pham.*')
            ->get();
    } else {
        // 💛 Chưa đăng nhập → lấy từ session (hoặc tạm từ localStorage)
        $wishlist = session('wishlist', []);

        // Nếu chỉ lưu ID trong session
        $wishlistItems = Product::whereIn('id', $wishlist)->get();
    }

    // ✅ Giải mã JSON ảnh nếu cần
    $wishlistItems = $wishlistItems->map(function ($item) {
        if (!empty($item->anh) && is_string($item->anh)) {
            $decoded = json_decode($item->anh, true);
            $item->anh = is_array($decoded) ? $decoded : [];
        }
        return $item;
    });

    return view('wishlist', compact('wishlistItems'));
}


    // 📋 API lấy danh sách wishlist
   public function list(Request $request)
{
    // Nếu user đã login, lấy product_id từ bảng wishlist của user
    if (Auth::check()) {
        $productIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
    } else {
        // Nếu guest → nhận mảng id gửi từ JS (local_items)
        $productIds = $request->input('local_items', []);
    }

    // Lấy products theo id (nếu rỗng sẽ trả collection rỗng)
    $products = Product::whereIn('id', $productIds)->get();

    // Chuẩn hoá dữ liệu trả về: decode ảnh JSON, trả các trường cần dùng
    $items = $products->map(function ($p) {
        // Nếu cột 'anh' là JSON string → decode
        $anhData = [];
        if (!empty($p->anh)) {
            if (is_string($p->anh)) {
                $decoded = json_decode($p->anh, true);
                $anhData = is_array($decoded) ? $decoded : [];
            } elseif (is_array($p->anh)) {
                $anhData = $p->anh;
            }
        }

        // xác định ảnh chính (nếu bạn lưu cấu trúc anh_chinh / anh_phu)
        $anh_chinh = $anhData['anh_chinh'] ?? ($anhData['anh_phu'][0] ?? null);

        return [
            'id' => $p->id,
            'ten_san_pham' => $p->ten_san_pham,
            'gia' => $p->gia,
            'gia_khuyen_mai' => $p->gia_khuyen_mai ?? null,
            'anh' => $anhData,
            'anh_chinh' => $anh_chinh,
            // thêm trường bạn cần (slug, url, v.v.)
        ];
    })->values();

    return response()->json([
        'status' => 'success',
        'items' => $items,
        'count' => $items->count(),
    ]);
}

    // ❤️ Thêm hoặc xóa yêu thích (chỉ khi đã login)
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'guest',
                'message' => 'Vui lòng đăng nhập để lưu vĩnh viễn.',
            ]);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Đã xoá khỏi danh sách yêu thích.';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích.';
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'status' => $status,
            'message' => $message,
            'count' => $count,
        ]);
    }

    // 🔁 Khi user đăng nhập, đồng bộ wishlist tạm (localStorage) vào DB
    public function sync(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Chưa đăng nhập']);
        }

        $localItems = $request->input('local_items', []);
        $userId = Auth::id();

        foreach ($localItems as $productId) {
            Wishlist::firstOrCreate([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã đồng bộ danh sách yêu thích.',
        ]);
    }
}
