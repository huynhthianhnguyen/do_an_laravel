@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-lg mx-auto">
    <h2 class="text-xl font-semibold mb-4">Thêm danh mục</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tên danh mục</label>
            <input type="text" name="ten_danh_muc" value="{{ old('ten_danh_muc') }}" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Ảnh đại diện</label>
            <input type="file" name="anh_dai_dien" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lưu</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600 hover:underline">Hủy</a>
    </form>
</div>
@endsection
