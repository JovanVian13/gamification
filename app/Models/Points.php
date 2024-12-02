<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $table = 'points';
    protected $fillable = ['user_id', 'points', 'period', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
