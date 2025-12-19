<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function pending()
    {
        $orders = Order::where('status', 'pending')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function shipping()
    {
        $orders = Order::where('status', 'shipping')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function completed()
    {
        $orders = Order::where('status', 'completed')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function cancelled()
    {
        $orders = Order::where('status', 'cancelled')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,shipping,completed,cancelled',
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Cập nhật trạng thái thành công!');
}

}
