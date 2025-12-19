@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="p-6 space-y-6">
    <!-- 🟦 Hàng thẻ thống kê -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white p-4 rounded-2xl shadow">
            <h3 class="text-gray-500 text-sm">Tổng số đơn hàng</h3>
            <p class="text-3xl font-semibold mt-2">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <h3 class="text-gray-500 text-sm">Đơn hàng đang xử lý</h3>
            <p class="text-3xl font-semibold mt-2">{{ $processingOrders }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <h3 class="text-gray-500 text-sm">Đơn hàng đã giao</h3>
           <p class="text-3xl font-semibold mt-2">{{ $shippingOrders }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <h3 class="text-gray-500 text-sm">Doanh thu</h3>
            <p class="text-3xl font-semibold mt-2 text-green-600">{{ number_format($revenue, 0, ',', '.') }} ₫</p>
        </div>
    </div>

    <!-- 🟧 Biểu đồ -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-lg font-semibold mb-4">Doanh thu & Đơn hàng theo tháng</h2>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <!-- 🟩 Bảng đơn hàng gần đây -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold">Đơn hàng gần đây</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-500 text-sm hover:underline">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Số đơn</th>
                        <th class="p-3">Tên</th>
                        <th class="p-3">Điện thoại</th>
                        <th class="p-3">Tổng tiền</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">#{{ $order->id }}</td>
                        <td class="p-3">{{ $order->name }}</td>
                        <td class="p-3">{{ $order->phone }}</td>
                        <td class="p-3">{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                   ($order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [
            {
                label: 'Doanh thu (₫)',
                data: {!! json_encode($revenues) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.6)',
                yAxisID: 'yRevenue'
            },
            {
                label: 'Số đơn hàng',
                data: {!! json_encode($ordersCount) !!},
                backgroundColor: 'rgba(251, 191, 36, 0.6)',
                yAxisID: 'yOrders'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            yRevenue: {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                ticks: { callback: function(value){ return value.toLocaleString() + ' ₫'; } },
                title: { display: true, text: 'Doanh thu' }
            },
            yOrders: {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                grid: { drawOnChartArea: false }, // không vẽ lưới trùng với trục doanh thu
                title: { display: true, text: 'Số đơn hàng' }
            }
        }
    }
});
</script>

@endsection
