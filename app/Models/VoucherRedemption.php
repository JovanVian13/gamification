<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'points_used',
        'status',
    ];
}
