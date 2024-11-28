<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManage extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        'title',
        'description',
        'type',
        'points',
        'url',
        'deadline',
    ];

    // Ensure 'deadline' is cast to a Carbon instance
    protected $casts = [
        'deadline' => 'datetime',
    ];
}
