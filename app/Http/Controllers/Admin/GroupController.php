<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhomSanPham;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // Hiển thị danh sách nhóm sản phẩm
    public function index()
    {
        // Nên dùng paginate để dễ hiển thị danh sách dài
        $groups = NhomSanPham::orderBy('id', 'desc')->paginate(10);
        return view('admin.groups.index', compact('groups'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        return view('admin.groups.create');
    }

    // Xử lý lưu nhóm mới
    public function store(Request $request)
    {
        $request->validate([
            'ten_nhom' => 'required|string|max:255',
            'id_danh_muc' => 'nullable|integer',
        ]);

        NhomSanPham::create([
            'ten_nhom' => $request->ten_nhom,
            'id_danh_muc' => $request->id_danh_muc,
        ]);

        return redirect()->route('admin.groups.index')->with('success', 'Thêm nhóm sản phẩm thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit(NhomSanPham $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    // Cập nhật dữ liệu nhóm sản phẩm
    public function update(Request $request, NhomSanPham $group)
    {
        $request->validate([
            'ten_nhom' => 'required|string|max:255',
            'id_danh_muc' => 'nullable|integer',
        ]);

        $group->update([
            'ten_nhom' => $request->ten_nhom,
            'id_danh_muc' => $request->id_danh_muc,
        ]);

        return redirect()->route('admin.groups.index')->with('success', 'Cập nhật nhóm sản phẩm thành công!');
    }

    // Xóa nhóm sản phẩm
    public function destroy(NhomSanPham $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Xóa nhóm sản phẩm thành công!');
    }
}
