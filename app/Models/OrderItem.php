<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ thêm dòng này
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory; // ✅ trait đúng

    protected $fillable = [
        'order_id',
        'product_id',
        'ten_san_pham',
        'quantity',
        'gia',
        'tong_tien',
        'color',
        'size',
       
    ];

    // Nếu bạn có mối quan hệ thì thêm luôn (tùy chọn)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
