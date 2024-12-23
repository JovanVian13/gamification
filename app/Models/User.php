<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

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
            ->withPivot('redeemed_at','created_at','updated_at')
            ->withTimestamps();
    }
    

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function points()
    {
        return $this->hasMany(Points::class, 'user_id');
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
            'period' => now()->format('F Y'),
            'date' => now(),
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        // Event: Assign tasks to new user when account is created
        static::created(function ($user) {
            // Ambil semua tugas yang tersedia dan belum melewati deadline
            $tasks = TaskManage::where('deadline', '>=', now())->get();

            foreach ($tasks as $task) {
                // Assign tugas ke pengguna baru
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }

            Log::info("Tasks assigned to new user: {$user->id}");
        });
    }
}
