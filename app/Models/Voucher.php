<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'points_required', 'status'];

    // Relasi dengan User
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status', 'redeemed_at') // Menambahkan kolom pivot yang digunakan
            ->withTimestamps(); // Menambahkan waktu pembuatan dan update
    }
}
