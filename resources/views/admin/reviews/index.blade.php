@extends('layouts.admin')
@section('title', 'Đánh giá')
@section('content')
<div class="container">
    <h3 class="mb-4">Danh sách đánh giá</h3>
    <table class="table table-hover table-striped table-bordered custom-table">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Sao</th>
                <th>Nội dung</th>
                <th>Ngày</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->product->ten_san_pham ?? '—' }}</td>
                    <td>{{ $r->user->name ?? $r->name ?? 'Khách' }}</td>
                    <td>{{ $r->rating }}</td>
                    <td>{{ Str::limit($r->comment, 80) }}</td>
                    <td>{{ $r->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Chưa có đánh giá</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.custom-table {
    border-collapse: separate;
    border-spacing: 0 10px; /* khoảng cách giữa các hàng */
}

.custom-table th, .custom-table td {
    vertical-align: middle;
    padding: 12px 15px;
}

.custom-table tbody tr {
    background-color: #f9f9f9;
    transition: all 0.3s;
}

.custom-table tbody tr:hover {
    background-color: #e2f0ff;
}

.custom-table th {
    text-align: center;
    font-weight: 600;
}

.table-bordered {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}
</style>
@endsection
