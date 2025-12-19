<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhomSanPham extends Model
{
    use HasFactory;

    protected $table = 'nhom_san_pham'; 

    protected $fillable = [
        'id_danh_muc',
        'ten_nhom',
    ];

    // Nếu bạn có bảng danh mục, thêm quan hệ (tùy chọn)
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'id_danh_muc');
    }
}
