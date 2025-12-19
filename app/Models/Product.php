<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'san_pham';
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_nhom',
        'id_bo_suu_tap',
        'ten_san_pham',
        'gia',
        'gia_khuyen_mai',
        'mau_sac',
        'kich_thuoc',
        'ma_sp',
        'mo_ta',
        'so_luong',
        'anh',
    ];

    protected $casts = [
        'anh' => 'array',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'id_bo_suu_tap');
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
}
