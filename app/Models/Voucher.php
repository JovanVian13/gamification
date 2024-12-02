<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'points_required', 'code', 'status'];

    // Relasi dengan User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_voucher')
            ->withPivot('status', 'redeemed_at')
            ->withTimestamps();
    }
    
}
