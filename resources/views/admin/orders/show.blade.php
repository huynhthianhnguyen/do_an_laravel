@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

<div class="bg-white p-4 rounded shadow mb-4">
    <p><strong>Khách hàng:</strong> {{ $order->name }}</p>
    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
</div>

<h2 class="text-xl font-bold mb-2">Sản phẩm</h2>

<table class="w-full border">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-2">Sản phẩm</th>
            <th class="p-2">SL</th>
            <th class="p-2">Giá</th>
            <th class="p-2">Tổng</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalAmount = 0;
        @endphp
       @foreach ($order->items as $item)
    @php
        $lineTotal = $item->quantity * $item->gia;
        $totalAmount += $lineTotal;
    @endphp
    <tr class="border-t">
        <td class="p-2">{{ $item->product->ten_san_pham ?? 'Không còn' }}</td>
        <td class="p-2">{{ $item->quantity }}</td>
        <td class="p-2">{{ number_format($item->gia) }} đ</td>
        <td class="p-2">{{ number_format($lineTotal) }} đ</td>
    </tr>
@endforeach

    </tbody>

    <tfoot>
        <tr class="bg-gray-100 font-bold">
            <td class="p-2 text-right" colspan="3">Tổng tiền:</td>
            <td class="p-2">{{ number_format($totalAmount) }} đ</td>
        </tr>
    </tfoot>
</table>

<!-- Cập nhật trạng thái -->
<form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-4">
    @csrf

    <label class="block font-semibold">Cập nhật trạng thái</label>
    <select name="status" class="border rounded p-2 mt-1">
        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Chờ xử lý</option>
        <option value="shipping" {{ $order->status=='shipping'?'selected':'' }}>Đang giao</option>
        <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Đã hoàn thành</option>
        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Đã hủy</option>
    </select>

    <button class="ml-2 px-4 py-2 bg-green-600 text-white rounded">
        Cập nhật
    </button>
</form>

@endsection
