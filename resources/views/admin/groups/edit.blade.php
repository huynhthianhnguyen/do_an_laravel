@extends('layouts.admin')

@section('title', 'Sửa nhóm sản phẩm')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Sửa nhóm sản phẩm</h2>

    <form action="{{ route('admin.groups.update', $group->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-1">Tên nhóm</label>
            <input type="text" name="ten_nhom" value="{{ old('ten_nhom', $group->ten_nhom) }}"
                   class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('ten_nhom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Mã danh mục</label>
            <input type="number" name="id_danh_muc" value="{{ old('id_danh_muc', $group->id_danh_muc) }}"
                   class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.groups.index') }}" class="px-4 py-2 bg-gray-200 rounded mr-2">⬅️ Quay lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">💾 Cập nhật</button>
        </div>
    </form>
</div>
@endsection
