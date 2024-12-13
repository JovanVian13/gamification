<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherManage extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $fillable = ['title', 'description', 'points_required', 'code', 'status', 'expired_date',];

    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status', 'redeemed_at') 
            ->withTimestamps();
    }
}
