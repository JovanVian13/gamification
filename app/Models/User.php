<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'age', 'location', 'last_login',
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
        'last_login' => 'datetime',
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
        return $this->belongsToMany(Voucher::class, 'user_voucher')
            ->withPivot('status', 'redeemed_at') // Kolom tambahan di tabel pivot
            ->withTimestamps(); // Untuk timestamps otomatis
    }
    

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at') // Kolom tambahan di tabel pivot
                    ->withTimestamps(); // Untuk otomatis mengelola timestamps
    }

    public function points()
    {
        return $this->hasMany(Points::class, 'user_id'); // Relasi one-to-many
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class, 'user_id');
    }

    public function addPoints($points)
    {
        $this->points()->create([
            'points' => $points,
            'period' => now()->format('F Y'), // Bulan dan tahun
            'date' => now(), // Tanggal poin diberikan
        ]);
    }

}
