<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    // optional: các method khác (create, store, edit, update, destroy) nếu cần
}
