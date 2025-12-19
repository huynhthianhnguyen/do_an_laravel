@extends('layouts.admin')

@section('title', 'Bộ sưu tập')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Danh sách bộ sưu tập</h2>
        <a href="{{ route('admin.collections.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           ➕ Thêm bộ sưu tập
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-200 text-sm">
        <thead class="bg-gray-100">
            <tr class="text-left">
                <th class="p-3 border-b">#</th>
                <th class="p-3 border-b">Tên bộ sưu tập</th>
                <th class="p-3 border-b">Mô tả</th>
                <th class="p-3 border-b">Ảnh đại diện</th>
                <th class="p-3 border-b text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($collections as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $loop->iteration }}</td>
                    <td class="p-3 border-b">{{ $item->ten_bo_suu_tap }}</td>
                    <td class="p-3 border-b">{{ Str::limit($item->mo_ta, 50) }}</td>
                    <td class="p-3 border-b">
                       @if ($item->anh_dai_dien)
    <img src="{{ asset('assets/' . $item->anh_dai_dien) }}"
     alt="Ảnh" class="w-16 h-16 object-cover rounded">

@else
    <span class="text-gray-400">Không có</span>
@endif


                    </td>
                    <td class="p-3 border-b text-center">
                        <a href="{{ route('admin.collections.edit', $item->id) }}"
                           class="text-blue-600 hover:underline mr-3">✏️ Sửa</a>
                        <form action="{{ route('admin.collections.destroy', $item->id) }}" method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Chưa có bộ sưu tập nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $collections->links() }}
    </div>
</div>
@endsection
