<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'is_done'
    ];

    // 型指定
    protected $casts = [
        'is_done'=>'bool'
    ];
}
