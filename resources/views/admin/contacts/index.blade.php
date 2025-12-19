@extends('layouts.admin')
@section('title', 'Liên hệ')
@section('content')

<div class="container my-4">
    <h3 class="mb-4 text-center">Danh sách liên hệ</h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên khách</th>
                    <th scope="col">Email</th>
                    <th scope="col">Chủ đề</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Ngày gửi</th>
                </tr>
            </thead>

            <tbody>
                {{-- Dòng dữ liệu tĩnh ví dụ --}}
                <tr class="table-info">
                    <td>0</td>
                    <td>Nguyễn Văn A</td>
                    <td>nguyenvana@example.com</td>
                    <td>Phản hồi sản phẩm</td>
                    <td>Rất hài lòng về sản phẩm, chất lượng tốt và giao hàng nhanh.</td>
                    <td>2025-11-30</td>
                </tr>

                @forelse ($contacts as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->subject ?? '—' }}</td>
                        <td>{{ Str::limit($c->message, 80) }}</td>
                        <td>{{ $c->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Chưa có liên hệ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
