<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ thêm dòng này
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory; // ✅ trait đúng

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'city',
        'district',
        'address',
        'payment_method',
        'subtotal',
        'shipping_fee',
        'vat',
        'total',
        'status',
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
