<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'is_done', 'user_id'
    ];

    // 型指定
    protected $casts = [
        'is_done'=>'bool',
        'user_id'=>'int',
    ];
}
