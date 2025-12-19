@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow">
    <h2 class="text-xl font-semibold mb-4">Chỉnh sửa sản phẩm</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Tên sản phẩm</label>
            <input type="text" name="ten_san_pham" value="{{ old('ten_san_pham', $product->ten_san_pham) }}" class="w-full border rounded p-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Giá</label>
                <input type="number" name="gia" value="{{ old('gia', $product->gia) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-gray-700">Giá khuyến mãi</label>
                <input type="number" name="gia_khuyen_mai" value="{{ old('gia_khuyen_mai', $product->gia_khuyen_mai) }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Màu sắc</label>
                <input type="text" name="mau_sac" value="{{ old('mau_sac', $product->mau_sac) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-gray-700">Kích thước</label>
                <input type="text" name="kich_thuoc" value="{{ old('kich_thuoc', $product->kich_thuoc) }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Mã sản phẩm</label>
                <input type="text" name="ma_sp" value="{{ old('ma_sp', $product->ma_sp) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-gray-700">Số lượng</label>
                <input type="number" name="so_luong" value="{{ old('so_luong', $product->so_luong) }}" class="w-full border rounded p-2" min="0">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Mô tả</label>
            <textarea name="mo_ta" rows="4" class="w-full border rounded p-2">{{ old('mo_ta', $product->mo_ta) }}</textarea>
        </div>

        <div>
           <label class="block text-gray-700 mb-1">Ảnh hiện tại</label>
@php
    $images = is_array($product->anh) ? $product->anh : json_decode($product->anh, true);
@endphp

@if(!empty($images))
    {{-- Ảnh chính --}}
    @if(!empty($images['anh_chinh']))
        <div class="mb-2">
            <p class="text-sm font-semibold text-gray-600">Ảnh chính:</p>
            <img src="{{ asset('assets/' . ltrim($images['anh_chinh'], '/')) }}" 
                 alt="Ảnh chính"
                 class="w-24 h-24 object-cover rounded-md border mb-2">
        </div>
    @endif

    {{-- Ảnh phụ --}}
    @if(!empty($images['anh_phu']) && is_array($images['anh_phu']))
        <div>
            <p class="text-sm font-semibold text-gray-600">Ảnh phụ:</p>
            @foreach ($images['anh_phu'] as $img)
                <img src="{{ asset('assets/' . ltrim($img, '/')) }}" 
                     alt="Ảnh phụ"
                     class="w-20 h-20 object-cover rounded-md inline-block mr-2 mb-2 border">
            @endforeach
        </div>
    @endif
@else
    <p class="text-gray-500 text-sm">Chưa có ảnh</p>
@endif


        <div>
            <label class="block text-gray-700">Cập nhật ảnh mới (nếu có)</label>
            <input type="file" name="anh[]" multiple class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Cập nhật
        </button>
    </form>
</div>
@endsection
