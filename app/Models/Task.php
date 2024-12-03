<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'points', 'url', 'deadline', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks')
                    ->withPivot('status', 'completed_at')
                    ->withTimestamps();
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

}

