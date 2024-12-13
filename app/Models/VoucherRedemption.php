<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VoucherRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'points_used',
        'redeemed_at',
    ];

    // Relasi ke model Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Ambil status dari tabel vouchers
    public function getStatusAttribute()
    {
        // Ambil status dari relasi Voucher
        return $this->voucher->status ?? 'unknown';
    }

    // Ambil expired_date dari tabel vouchers
    public function getExpiredDateAttribute()
    {
        // Ambil expired_date dari relasi Voucher
        return $this->voucher->expired_date ?? null;
    }
}
