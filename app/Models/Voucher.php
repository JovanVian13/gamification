<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'points_required', 
        'code', 
        'status', 
        'expired_date',
    ];

    // Relasi dengan User (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_voucher')
            ->withPivot('redeemed_at')
            ->withTimestamps();
    }
    
    // Status otomatis berdasarkan expired_date
    public function getStatusAttribute($value)
    {
        if ($this->expired_date && Carbon::now()->greaterThanOrEqualTo($this->expired_date)) {
            return 'expired';
        }
        return $value ?: 'active'; // Status default "active" jika tidak ada nilai
    }
}
