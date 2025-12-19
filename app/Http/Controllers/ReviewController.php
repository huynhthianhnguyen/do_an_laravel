<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:san_pham,id',
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|max:255',
        'rating'     => 'required|integer|min:1|max:5',
        'review'     => 'required|string',
    ]);

    Review::create([
        'product_id' => $request->product_id,
        'name'       => $request->name,
        'email'      => $request->email,
        'rating'     => $request->rating,
        'review'     => $request->review,
    ]);

    return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
}

}
