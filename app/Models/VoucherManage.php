<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VoucherManage extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $fillable = [
        'title', 
        'description', 
        'points_required', 
        'code', 
        'status', 
        'expired_date',
    ];

    // Konstanta untuk status
    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';

    // Relasi dengan pengguna
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
            return self::STATUS_EXPIRED;
        }
        return $value ?: self::STATUS_ACTIVE;
    }
}
