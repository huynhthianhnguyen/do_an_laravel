<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Collection;


class ProductController extends Controller
{
    /**
     * Trang chủ - hiển thị các sản phẩm nổi bật, khuyến mãi, bộ sưu tập, ...
     */
    public function index()
    {
        // 🔹 Sản phẩm nổi bật
        $featured = DB::table('san_pham as sp')
            ->leftJoin('nhom_san_pham as nsp', 'sp.id_nhom', '=', 'nsp.id')
            ->select('sp.id', 'sp.ten_san_pham', 'sp.gia', 'sp.gia_khuyen_mai', 'sp.anh', 'nsp.ten_nhom')
            ->orderByDesc('sp.id')
            ->limit(8)
            ->get();

        // 🔹 Sản phẩm khuyến mãi
        $hotDeals = DB::table('san_pham as sp')
            ->leftJoin('nhom_san_pham as nsp', 'sp.id_nhom', '=', 'nsp.id')
            ->whereNotNull('sp.gia_khuyen_mai')
            ->whereColumn('sp.gia_khuyen_mai', '<', 'sp.gia')
            ->orderByRaw('(sp.gia - sp.gia_khuyen_mai) / sp.gia DESC')
            ->select('sp.id', 'sp.ten_san_pham', 'sp.gia', 'sp.gia_khuyen_mai', 'sp.anh', 'nsp.ten_nhom')
            ->limit(4)
            ->get();

        // 🔹 Gợi ý nhóm sản phẩm
        $youMayLike = DB::table('nhom_san_pham as nsp')
            ->join('san_pham as sp', 'nsp.id', '=', 'sp.id_nhom')
            ->select('nsp.id', 'nsp.ten_nhom', DB::raw('MIN(sp.anh) as anh'))
            ->groupBy('nsp.id', 'nsp.ten_nhom')
            ->limit(8)
            ->get();

        // 🔹 Bộ sưu tập (cho slider)
        $collections = DB::table('bo_suu_tap')
            ->select('id', 'ten_bo_suu_tap', 'anh_dai_dien', 'mo_ta')
            ->limit(3)
            ->get();

        // 🔹 Sản phẩm yêu thích
        $wishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : array_keys(session('wishlist', []));

        return view('index', compact('featured', 'hotDeals', 'youMayLike', 'collections', 'wishlistIds'));
    }

    /**
     * Trang danh sách sản phẩm (Shop)
     */
    public function shop(Request $request)
    {
        $query = DB::table('san_pham as sp')
            ->join('nhom_san_pham as n', 'sp.id_nhom', '=', 'n.id')
            ->join('danh_muc as dm', 'n.id_danh_muc', '=', 'dm.id')
            ->select('sp.*', 'n.ten_nhom', 'dm.ten_danh_muc');

        // ====== Bộ lọc ======
        if ($request->filled('group')) {
            $query->where('n.id', $request->group);
        } elseif ($request->filled('category')) {
            $query->where('n.id_danh_muc', $request->category);
        }

        if ($request->filled('color')) {
            $query->whereNotNull('sp.mau_sac')
                  ->where('sp.mau_sac', 'like', '%' . $request->color . '%');
        }

        if ($request->filled('size')) {
            $query->whereNotNull('sp.kich_thuoc')
                  ->where('sp.kich_thuoc', 'like', '%' . $request->size . '%');
        }

        if ($request->filled('keyword')) {
            $query->where('sp.ten_san_pham', 'LIKE', '%' . $request->keyword . '%');
        }

        // ====== Sắp xếp ======
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az': $query->orderBy('sp.ten_san_pham', 'asc'); break;
                case 'za': $query->orderBy('sp.ten_san_pham', 'desc'); break;
                case 'price_asc': $query->orderBy(DB::raw('COALESCE(sp.gia_khuyen_mai, sp.gia)'), 'asc'); break;
                case 'price_desc': $query->orderBy(DB::raw('COALESCE(sp.gia_khuyen_mai, sp.gia)'), 'desc'); break;
                case 'newest': $query->orderBy('sp.id', 'desc'); break;
                case 'oldest': $query->orderBy('sp.id', 'asc'); break;
            }
        }

        // Phân trang
        $products = $query->paginate(12)->withQueryString();

        // Sidebar data
        $categories = DB::table('danh_muc')->get();
        $groupsByCategory = DB::table('nhom_san_pham')->get()->groupBy('id_danh_muc');
        $colors = DB::table('san_pham')->pluck('mau_sac');
        $sizes = DB::table('san_pham')->pluck('kich_thuoc');
        $collections = DB::table('bo_suu_tap')->get();

        $wishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : array_keys(session('wishlist', []));

        return view('shop', compact('products', 'categories', 'groupsByCategory', 'colors', 'sizes', 'collections', 'wishlistIds'));
    }

    /**
     * Chi tiết sản phẩm
     */
    public function details($id)
    {
        $product = DB::table('san_pham')
            ->leftJoin('nhom_san_pham', 'san_pham.id_nhom', '=', 'nhom_san_pham.id')
            ->leftJoin('danh_muc', 'nhom_san_pham.id_danh_muc', '=', 'danh_muc.id')
            ->select('san_pham.*', 'nhom_san_pham.id_danh_muc', 'nhom_san_pham.ten_nhom', 'danh_muc.ten_danh_muc')
            ->where('san_pham.id', $id)
            ->first();

        if (!$product) abort(404, 'Sản phẩm không tồn tại');

        $product->anh = json_decode($product->anh ?? '{}', true) ?: [];

        $categoryId = DB::table('nhom_san_pham')
            ->where('id', $product->id_nhom)
            ->value('id_danh_muc');

        $related = DB::table('san_pham')
            ->join('nhom_san_pham', 'san_pham.id_nhom', '=', 'nhom_san_pham.id')
            ->where('nhom_san_pham.id_danh_muc', $categoryId)
            ->where('san_pham.id', '!=', $product->id)
            ->select('san_pham.id', 'san_pham.ten_san_pham', 'san_pham.gia', 'san_pham.gia_khuyen_mai', 'san_pham.anh')
            ->limit(4)
            ->get()
            ->map(fn($item) => tap($item, fn($p) => $p->anh = json_decode($p->anh ?? '{}', true)));
        $reviews = DB::table('reviews')
    ->where('product_id', $product->id)
    ->orderBy('created_at', 'DESC')
    ->get();


       return view('details', compact('product', 'related', 'reviews'));
    }

    /**
     * Gợi ý tìm kiếm (AJAX)
     */
    public function searchSuggestions(Request $request)
    {
        $keyword = $request->keyword;
        $products = DB::table('san_pham')
            ->where('ten_san_pham', 'like', "%$keyword%")
            ->limit(8)
            ->get(['id', 'ten_san_pham as name', 'anh']);

        foreach ($products as $product) {
            $anh = json_decode($product->anh ?? '{}', true);
            $product->image = $anh['anh_chinh'] ?? 'images/default.jpg';
        }

        $keywords = DB::table('san_pham')
            ->where('ten_san_pham', 'like', "%$keyword%")
            ->pluck('ten_san_pham')
            ->take(10)
            ->toArray();

        return response()->json(['keywords' => $keywords, 'products' => $products]);
    }

    public function showCollection($id)
{
    // Lấy bộ sưu tập theo ID
    $collection = \App\Models\Collection::findOrFail($id);

    // Lấy danh sách sản phẩm thuộc bộ sưu tập này
    $products = Product::where('id_bo_suu_tap', $id)->paginate(12);
    // Trả về view hiển thị bộ sưu tập
    return view('showcollection', compact('collection', 'products'));
}

 public function loadMoreHotDeals(Request $request)
    {
        $offset = (int) $request->get('offset', 0);
        $limit = 4;

        $hotDeals = DB::table('san_pham as sp')
            ->leftJoin('nhom_san_pham as nsp', 'sp.id_nhom', '=', 'nsp.id')
            ->whereNotNull('sp.gia_khuyen_mai')
            ->whereColumn('sp.gia_khuyen_mai', '<', 'sp.gia')
            ->orderByRaw('(sp.gia - sp.gia_khuyen_mai) / sp.gia DESC')
            ->select(
                'sp.id',
                'sp.ten_san_pham',
                'sp.gia',
                'sp.gia_khuyen_mai',
                'sp.anh',
                'nsp.ten_nhom'
            )
            ->offset($offset)
            ->limit($limit)
            ->get();

        $html = '';
        foreach ($hotDeals as $product) {
            $anh = json_decode($product->anh ?? '', true);
            $anh_chinh = $anh['anh_chinh'] ?? $anh['anh_phu'][0] ?? 'images/default.jpg';
            $anh_chinh = ltrim($anh_chinh, '/');

            $html .= '
            <div class="col-6 col-md-3">
                <div class="product-card border-0 bg-white h-100 p-2 rounded shadow-sm">
                    <a href="' . route('products.details', $product->id) . '" class="d-block position-relative">
                        <img src="' . asset('assets/' . $anh_chinh) . '" 
                             onerror="this.src=\'' . asset('assets/images/default.jpg') . '\';" 
                             class="img-fluid rounded" 
                             alt="' . e($product->ten_san_pham) . '">
                        <button class="btn-wishlist" data-id="' . $product->id . '">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </a>
                    <div class="pt-2 text-center">
                        <h6 class="fw-normal mb-1">' . e($product->ten_san_pham) . '</h6>
                        <div class="text-secondary small">
                            <span class="text-decoration-line-through me-2 text-muted">'
                                . number_format($product->gia, 0, ',', '.') . '₫
                            </span>
                            <span class="fw-medium text-dark">'
                                . number_format($product->gia_khuyen_mai, 0, ',', '.') . '₫
                            </span>
                        </div>
                    </div>
                </div>
            </div>';
        }

        return response($html);
    }
public function loadMoreFeatured(Request $request)
{
    $page = $request->get('page', 1);
    $perPage = 8;

    // Lấy sản phẩm theo trang (phân trang thủ công)
    $products = DB::table('san_pham')
        ->orderBy('id', 'desc')
        ->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get();

    // Nếu không còn sản phẩm thì trả về rỗng
    if ($products->isEmpty()) {
        return '';
    }

    $html = '';

    foreach ($products as $product) {
        // Giải mã ảnh (lưu JSON trong DB)
        $anh = json_decode($product->anh, true);
        $anh_chinh = $anh['anh_chinh'] ?? 'images/default.jpg';

        // Format giá
        $gia = number_format($product->gia, 0, ',', '.');
        $gia_km = $product->gia_khuyen_mai
            ? number_format($product->gia_khuyen_mai, 0, ',', '.')
            : null;

        // Tạo HTML sản phẩm
        $html .= '
        <div class="col">
            <div class="card border-0 shadow-sm h-100 product-card position-relative overflow-hidden">
                <a href="' . route('products.details', $product->id) . '" class="d-block">
                    <div class="position-relative">
                        <img src="' . asset('assets/' . $anh_chinh) . '" class="card-img-top product-image" alt="' . e($product->ten_san_pham) . '">
                        <button class="btn-wishlist" data-id="' . $product->id . '">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </a>
                <div class="card-body text-center">
                    <h6 class="fw-semibold mb-1">' . e($product->ten_san_pham) . '</h6>';

        if ($gia_km) {
            $html .= '<p class="text-danger fw-bold mb-0">'
                . $gia_km . '₫ 
                <span class="text-muted text-decoration-line-through ms-1">'
                . $gia . '₫</span></p>';
        } else {
            $html .= '<p class="fw-bold mb-0">' . $gia . '₫</p>';
        }

        $html .= '
                </div>
            </div>
        </div>';
    }

    return $html;
}


}
