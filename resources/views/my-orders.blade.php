@extends('layouts.app')

@section('content')
<main class="pt-90 container">

    <h2 class="mb-4">Đơn hàng của tôi</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            Bạn chưa có đơn hàng nào.
        </div>
    @else

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Xem</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($order->total) }}₫</td>
                <td>
                    <span class="badge bg-secondary">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('my.orders.detail', $order->id) }}" 
                       class="btn btn-primary btn-sm">
                        Chi tiết
                    </a>
                    <td>
    <span class="badge bg-secondary">
        {{ ucfirst($order->status) }}
    </span>

    @if(in_array($order->status, ['pending', 'processing']))
        <form action="{{ route('my.orders.cancel', $order->id) }}" 
              method="POST" 
              style="display:inline-block" 
              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Hủy</button>
        </form>
    @endif
</td>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</main>
@endsection
