<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherManage extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $fillable = ['title', 'description', 'points_required', 'code', 'status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';
    // Relasi dengan User
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status', 'redeemed_at') // Menambahkan kolom pivot yang digunakan
            ->withTimestamps(); // Menambahkan waktu pembuatan dan update
    }
}
