<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'description', 'points_required', 'status'];

    // Relasi dengan user
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }
    
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->withPivot('status')->withTimestamps();
    }

}