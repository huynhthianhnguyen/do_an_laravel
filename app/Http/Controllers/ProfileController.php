<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa hồ sơ.
     */
    public function edit(Request $request)
    {
        // Trả về view và truyền user hiện tại
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Cập nhật hồ sơ.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate dữ liệu
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // Cập nhật tên
        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa tài khoản.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        return redirect('/')->with('success', 'Tài khoản đã được xóa!');
    }
}
