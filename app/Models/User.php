<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'age', 'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks')
                    ->withPivot('status', 'completed_at')
                    ->withTimestamps();
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)
            ->withPivot('status', 'redeemed_at')  // Tambahkan 'redeemed_at' di sini
            ->withTimestamps();  // Menambahkan timestamps otomatis
    }

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withTimestamps(); // Assuming a pivot table `user_badges` exists
    }

    public function points()
    {
        return $this->hasMany(Points::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
