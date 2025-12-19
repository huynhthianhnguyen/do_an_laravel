<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danh_muc'; // tên bảng trong DB
    protected $fillable = ['ten_danh_muc', 'anh_dai_dien'];
}
