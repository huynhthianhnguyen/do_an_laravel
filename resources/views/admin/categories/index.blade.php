@extends('layouts.admin')

@section('title', 'Danh mục')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Danh sách danh mục</h2>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Thêm danh mục</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border border-gray-200 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border-b">#</th>
                <th class="p-3 border-b">Tên danh mục</th>
                <th class="p-3 border-b">Ảnh đại diện</th>
                <th class="p-3 border-b text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $loop->iteration }}</td>
                    <td class="p-3 border-b">{{ $item->ten_danh_muc }}</td>
                    <td class="p-3 border-b">
                        @if ($item->anh_dai_dien)
                           <img src="{{ asset($item->anh_dai_dien) }}" alt="Ảnh" class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400">Không có</span>
                        @endif
                    </td>
                    <td class="p-3 border-b text-center">
                        <a href="{{ route('admin.categories.edit', $item->id) }}" class="text-blue-600 hover:underline mr-3">✏️ Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Chưa có danh mục nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $categories->links() }}</div>
</div>
@endsection
