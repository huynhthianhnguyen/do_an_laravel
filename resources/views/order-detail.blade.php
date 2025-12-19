@extends('layouts.app')

@section('content')
<main class="pt-90 container">

    <h2 class="mb-3">Chi tiết đơn hàng #{{ $order->id }}</h2>

    <div class="mb-3">
        <p><strong>Trạng thái:</strong> 
            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
        </p>

        <p><strong>Ngày đặt:</strong> 
            {{ $order->created_at->format('d/m/Y H:i') }}
        </p>

        <p><strong>Địa chỉ giao hàng:</strong> 
            {{ $order->address }}
        </p>
    </div>

    <h4 class="mt-4">Danh sách sản phẩm</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Màu</th>
                <th>Kích cỡ</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->ten_san_pham }}</td>
                <td>{{ $item->color }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->gia) }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 p-3 border rounded bg-light">
        <p><strong>Tạm tính:</strong> {{ number_format($order->subtotal) }}₫</p>
        <p><strong>VAT (10%):</strong> {{ number_format($order->vat) }}₫</p>
        <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee) }}₫</p>

        <h4 class="mt-2"><strong>Tổng cộng:</strong> 
            {{ number_format($order->total) }}₫
        </h4>
    </div>

    <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary mt-3">
        ← Quay lại danh sách đơn hàng
    </a>

</main>
@endsection
