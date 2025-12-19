@extends('layouts.admin')

@section('title', 'Thêm Sản Phẩm')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow">
    <h2 class="text-xl font-semibold mb-4">Thêm sản phẩm mới</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Tên sản phẩm</label>
            <input type="text" name="ten_san_pham" class="w-full border rounded p-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Giá</label>
                <input type="number" name="gia" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-gray-700">Giá khuyến mãi</label>
                <input type="number" name="gia_khuyen_mai" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Màu sắc</label>
                <input type="text" name="mau_sac" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-gray-700">Kích thước</label>
                <input type="text" name="kich_thuoc" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Mã sản phẩm</label>
                <input type="text" name="ma_sp" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-gray-700">Số lượng</label>
                <input type="number" name="so_luong" class="w-full border rounded p-2" min="0" value="0">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Nhóm sản phẩm (id_nhom)</label>
            <input type="number" name="id_nhom" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Bộ sưu tập (id_bo_suu_tap)</label>
            <input type="number" name="id_bo_suu_tap" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Mô tả</label>
            <textarea name="mo_ta" rows="4" class="w-full border rounded p-2"></textarea>
        </div>

        <div>
            <label class="block text-gray-700">Ảnh sản phẩm</label>
            <input type="file" name="anh[]" multiple class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Thêm sản phẩm
        </button>
    </form>
</div>
@endsection
