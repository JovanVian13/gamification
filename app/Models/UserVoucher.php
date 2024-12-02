<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'voucher_id', 'status', 'redeemed_at'];
    protected $table = 'user_voucher'; // Pastikan nama tabel sesuai


    // Relasi ke Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
