@extends('layouts.admin')

@section('title', 'Nhóm sản phẩm')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Danh sách nhóm sản phẩm</h2>
        <a href="{{ route('admin.groups.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           ➕ Thêm nhóm
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
                <th class="p-3 border-b">Tên nhóm</th>
                <th class="p-3 border-b">Mã danh mục</th>
                <th class="p-3 border-b text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groups as $group)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $loop->iteration }}</td>
                    <td class="p-3 border-b">{{ $group->ten_nhom }}</td>
                    <td class="p-3 border-b">{{ $group->id_danh_muc ?? '—' }}</td>
                    <td class="p-3 border-b text-center">
                        <a href="{{ route('admin.groups.edit', $group->id) }}"
                           class="text-blue-600 hover:underline mr-3">✏️ Sửa</a>
                        <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Bạn có chắc muốn xóa nhóm này không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Chưa có nhóm sản phẩm nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $groups->links() }}
    </div>
</div>
@endsection
