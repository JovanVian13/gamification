<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message', 'is_featured'];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
