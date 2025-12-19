<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';

    // Cho phép ghi các cột này
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Mỗi wishlist thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // (Tùy chọn) Mỗi wishlist thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
