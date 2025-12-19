<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; // nhớ import model

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // validate dữ liệu
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'comment' => 'required|string',
        ]);

        // lưu vào database
        Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'comment' => $request->comment,
        ]);

        // trả về thông báo thành công
        return back()->with('success', 'Gửi liên hệ thành công!');
    }
}
