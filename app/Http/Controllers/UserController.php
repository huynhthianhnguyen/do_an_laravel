<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Nếu là ADMIN → không cho vào trang user
        if (Auth::user()->utype === 'ADM') {
            return redirect()->route('admin.dashboard');
        }

        return view('user.index');
    }
}
