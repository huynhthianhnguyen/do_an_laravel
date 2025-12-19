@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Danh sách đơn hàng</h1>

{{-- Thanh lọc trạng thái --}}
<div class="mb-4 flex gap-2">
    <a href="{{ route('admin.orders.index') }}"
        class="px-3 py-1 rounded 
        {{ request()->routeIs('admin.orders.index') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Tất cả
    </a>

    <a href="{{ route('admin.orders.pending') }}"
        class="px-3 py-1 rounded 
        {{ request()->routeIs('admin.orders.pending') ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
        Đang chờ
    </a>

    <a href="{{ route('admin.orders.shipping') }}"
        class="px-3 py-1 rounded 
        {{ request()->routeIs('admin.orders.shipping') ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
        Đang giao
    </a>

    <a href="{{ route('admin.orders.completed') }}"
        class="px-3 py-1 rounded 
        {{ request()->routeIs('admin.orders.completed') ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        Hoàn thành
    </a>

    <a href="{{ route('admin.orders.cancelled') }}"
        class="px-3 py-1 rounded 
        {{ request()->routeIs('admin.orders.cancelled') ? 'bg-red-600 text-white' : 'bg-gray-200' }}">
        Đã hủy
    </a>
</div>

<table class="w-full border text-sm">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-2">ID</th>
            <th class="p-2">Tên KH</th>
            <th class="p-2">SĐT</th>
            <th class="p-2">Tổng tiền</th>
            <th class="p-2">Trạng thái</th>
            <th class="p-2">Ngày tạo</th>
            <th class="p-2">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-2">{{ $order->id }}</td>
            <td class="p-2">{{ $order->name }}</td>
            <td class="p-2">{{ $order->phone }}</td>
            <td class="p-2">{{ number_format($order->total) }} đ</td>

            {{-- Gán màu theo trạng thái --}}
            <td class="p-2">
                @php
                    $statusColor = [
                        'pending' => 'bg-yellow-200 text-yellow-800',
                        'shipping' => 'bg-blue-200 text-blue-800',
                        'completed' => 'bg-green-200 text-green-800',
                        'cancelled' => 'bg-red-200 text-red-800',
                    ];
                @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColor[$order->status] ?? 'bg-gray-200' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>

            <td class="p-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>

           <td class="p-2 flex flex-col gap-1">
    <a href="{{ route('admin.orders.show', $order->id) }}"
       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
        Xem
    </a>

    {{-- Nếu đơn hàng đang chờ, cho phép xác nhận vận chuyển --}}
    @if($order->status === 'pending')
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="shipping">
            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-center">
                Xác nhận vận chuyển
            </button>
        </form>
    @elseif($order->status === 'shipping')
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-center">
                Đã giao hàng
            </button>
        </form>
    @endif
</td>

        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
