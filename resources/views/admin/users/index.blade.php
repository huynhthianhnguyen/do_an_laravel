@extends('layouts.admin')

@section('title', 'Người dùng')

@section('content')
<h1 class="text-2xl font-bold mb-4">Danh sách người dùng</h1>

<table class="w-full bg-white border rounded-lg shadow-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Tên</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Vai trò</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr class="border-b">
                <td class="p-2">{{ $user->id }}</td>
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->utype === 'ADM' ? 'Admin' : 'Khách hàng' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
