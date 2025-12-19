<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Các cột được phép gán mass assignment
    protected $fillable = [
        'name',
        'email',
            'phone',
        'comment',
    ];
}
