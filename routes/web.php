<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ProductController as AdminProductController; 
use App\Http\Controllers\Admin\AdminOrderController; 
use App\Http\Controllers\Admin\CollectionController; 
use App\Http\Controllers\Admin\GroupController; 
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;



// ========================
// 🔐 AUTH ROUTES (Laravel Breeze/Jetstream)
// ========================
require __DIR__ . '/auth.php';

// ========================
// 🏠 TRANG CHỦ + SHOP
// ========================
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/details/{id}', [ProductController::class, 'details'])->name('products.details');
Route::get('/api/search-suggestions', [ProductController::class, 'searchSuggestions'])->name('products.searchSuggestions');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

// ========================
// 📦 SẢN PHẨM LIÊN QUAN & BỘ SƯU TẬP
// ========================
Route::prefix('san-pham')->group(function () {
    Route::get('/load-more', [ProductController::class, 'loadMore'])->name('products.loadMore');
    Route::get('/load-more-featured', [ProductController::class, 'loadMoreFeatured'])
    ->name('load.more.featured');
    Route::get('/category/{id}', [ProductController::class, 'category'])->name('category.show');
});
Route::get('/collection/{id}', [ProductController::class, 'showCollection'])->name('showcollection');
Route::get('/load-more-hot-deals', [ProductController::class, 'loadMoreHotDeals'])->name('hotdeals.loadMore');

// ========================
// 🛒 GIỎ HÀNG
// ========================
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// 💳 Thanh toán (bắt buộc đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// ========================
// 💝 DANH SÁCH YÊU THÍCH
// ========================
 Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
// Ai cũng có thể gọi list
Route::post('/wishlist/list', [WishlistController::class, 'list'])->name('wishlist.list');

// Đồng bộ sau khi login
Route::post('/wishlist/sync', [WishlistController::class, 'sync'])->middleware('auth');

// Toggle yêu thích (nếu login thì lưu DB, nếu chưa login thì chỉ thông báo)
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


// ========================
// 💳 THANH TOÁN
// ========================
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-confirmation/{id}', [OrderController::class, 'orderConfirmation'])->name('order.confirmation');
Route::get('/my-orders', [OrderController::class, 'myOrders'])
    ->middleware('auth')
    ->name('my.orders');
Route::get('/my-orders/{id}', [OrderController::class, 'orderDetail'])
    ->middleware('auth')
    ->name('my.orders.detail');
Route::post('/my-orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('my.orders.cancel');

// 🔸 MOMO
Route::get('/payment/momo/return', [MomoController::class, 'return'])->name('momo.return');
Route::post('/payment/momo/notify', [MomoController::class, 'notify'])->name('momo.notify');

// 🔸 VNPAY
Route::get('/payment/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');
Route::post('/payment/vnpay', [VNPayController::class, 'createPayment'])->name('vnpay.create');
// ========================
// 🎟️ MÃ GIẢM GIÁ (COUPON)
// ========================
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('applyCoupon');
Route::get('/remove-coupon', [CartController::class, 'removeCoupon'])->name('removeCoupon');
//contact
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ========================
// 📞 LIÊN HỆ + TRANG TĨNH
// ========================
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/about', 'about')->name('about');
Route::view('/chinh-sach-doi-tra', 'policy-return')->name('policy.return');
Route::view('/chinh-sach-van-chuyen', 'policy-banner')->name('policy.banner');
Route::view('/dieu-khoan-su-dung', 'provision')->name('provision');
Route::view('/chinh-sach-bao-mat', 'policy-checkout')->name('policy.checkout');
Route::view('/cau-hoi-thuong-gap', 'faq')->name('faq');
// ========================
// 👤 NGƯỜI DÙNG (AUTH)
// ========================
Route::middleware('auth')->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// 🛠️ QUẢN TRỊ VIÊN (ADMIN)
// ========================
Route::middleware(['auth', 'auth.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');
        // Quản lý sản phẩm
        Route::resource('products', AdminProductController::class);

        // Nhóm sản phẩm
        Route::resource('groups', GroupController::class);

        // Bộ sưu tập
        Route::resource('collections', CollectionController::class);

        // Danh mục
        Route::resource('categories', CategoryController::class);

        // Người dùng
        Route::resource('users', AdminUserController::class);
        // Liên hệ (Admin)
Route::resource('contacts', AdminContactController::class);

// Đánh giá (Admin)
Route::resource('reviews', AdminReviewController::class);


       // QUẢN LÝ ĐƠN HÀNG
Route::prefix('orders')->name('orders.')->group(function () {

    Route::get('/', [AdminOrderController::class, 'index'])->name('index');

    Route::get('/pending', [AdminOrderController::class, 'pending'])->name('pending');
    Route::get('/shipping', [AdminOrderController::class, 'shipping'])->name('shipping');
    Route::get('/completed', [AdminOrderController::class, 'completed'])->name('completed');
    Route::get('/cancelled', [AdminOrderController::class, 'cancelled'])->name('cancelled');
    Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
    Route::patch('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
});


    });

