<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'points_required', 'code', 'status', 'expired_date',];

    // Relasi dengan User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_voucher')
            ->withPivot('status', 'redeemed_at')
            ->withTimestamps();
    }
    
    public function getStatusAttribute($value)
    {
        if ($this->expired_date && Carbon::now()->greaterThanOrEqualTo($this->expired_date)) {
            return 'expired';
        }
        return $value;
    }
}
