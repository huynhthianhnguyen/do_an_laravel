@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Danh sách sản phẩm</h2>

    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Thêm sản phẩm</a>

    <table class="mt-4 w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Tên sản phẩm</th>
                <th class="p-2 border">Giá</th>
                <th class="p-2 border">Màu sắc</th>
                <th class="p-2 border">Số lượng</th>
                <th class="p-2 border">Ảnh</th>
                <th class="p-2 border">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
            <tr class="border-b">
                <td class="p-2">{{ $p->id }}</td>
                <td class="p-2">{{ $p->ten_san_pham }}</td>
                <td class="p-2">{{ number_format($p->gia) }} ₫</td>
                <td class="p-2">{{ $p->mau_sac }}</td>
                <td class="p-2">{{ $p->so_luong }}</td>
                <td class="p-2">
                  @if(!empty($p->anh))
        @php
            $images = is_array($p->anh) ? $p->anh : json_decode($p->anh, true);
            $image = $images['anh_chinh'] ?? ($images[0] ?? null);
        @endphp

        @if($image)
            <img src="{{ asset('assets/' . ltrim($image, '/')) }}" 
                 alt="{{ $p->ten_san_pham }}" 
                 class="w-16 h-16 object-cover rounded">
        @else
            <span class="text-gray-400 text-sm">Không có ảnh</span>
        @endif
    @else
        <span class="text-gray-400 text-sm">Không có ảnh</span>
    @endif

                </td>
                <td class="p-2">
                    <a href="{{ route('admin.products.edit', $p) }}" class="text-blue-600">Sửa</a> |
                    <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection
