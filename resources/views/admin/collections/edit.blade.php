@extends('layouts.admin')

@section('title', 'Chỉnh sửa bộ sưu tập')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">✏️ Chỉnh sửa bộ sưu tập</h2>

    <form action="{{ route('admin.collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên bộ sưu tập</label>
            <input type="text" name="ten_bo_suu_tap" value="{{ old('ten_bo_suu_tap', $collection->ten_bo_suu_tap) }}"
                   class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="mo_ta" rows="4" class="w-full border rounded p-2">{{ old('mo_ta', $collection->mo_ta) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Ảnh đại diện</label>
            @if ($collection->anh_dai_dien)
                <img src="{{ asset('storage/' . $collection->anh_dai_dien) }}"
                     alt="Ảnh đại diện" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="anh_dai_dien" class="w-full border rounded p-2">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
