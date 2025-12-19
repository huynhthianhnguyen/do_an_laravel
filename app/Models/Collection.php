<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'bo_suu_tap';

    protected $fillable = [
        'ten_bo_suu_tap',
        'mo_ta',
        'anh_dai_dien',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
