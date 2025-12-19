<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Review;
class AdminController extends Controller
{
    public function index()
    {
        // 🧮 Tổng quan
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $revenue = Order::sum('total');

        // 📦 Đơn hàng theo trạng thái
        $processingOrders = Order::where('status', 'pending')->count();   
        $shippingOrders   = Order::where('status', 'shipping')->count();  
        $completedOrders  = Order::where('status', 'completed')->count(); 
        $cancelledOrders  = Order::where('status', 'cancelled')->count(); 
         // Thống kê Feedback & Review
    $totalFeedbacks = Contact::count();
    $newFeedbacks = Contact::where('created_at', '>=', now()->subWeek())->count();

    $totalReviews = Review::count();
    $newReviews = Review::where('created_at', '>=', now()->subWeek())->count();

        // 🕓 Đơn hàng gần đây
        $recentOrders = Order::latest()->take(5)->get();

        // 📊 Dữ liệu cho biểu đồ theo tháng (12 tháng gần nhất)
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('m/Y');
        });

        $revenues = $months->map(function ($month) {
            [$m, $y] = explode('/', $month);
            return Order::whereMonth('created_at', $m)
                        ->whereYear('created_at', date('Y'))
                        ->sum('total');
        });

        $ordersCount = $months->map(function ($month) {
            [$m, $y] = explode('/', $month);
            return Order::whereMonth('created_at', $m)
                        ->whereYear('created_at', date('Y'))
                        ->count();
        });

        // ✅ Trả về view, dùng shippingOrders thay cho deliveredOrders
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'revenue',
            'processingOrders',
            'shippingOrders',   // <-- sửa ở đây
            'completedOrders',
            'cancelledOrders',
            'recentOrders',
            'months',
            'revenues',
            'ordersCount',
             'totalFeedbacks',   // thêm biến liên hệ
    'newFeedbacks',     // thêm biến liên hệ mới
    'totalReviews',     // thêm biến đánh giá
    'newReviews' 
        ));
    }
}
