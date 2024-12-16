<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserTask extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id', 'status', 'completed_at'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(TaskManage::class, 'task_id');
    }

    // Tandai tugas sebagai selesai dan tambahkan poin
    public function completeTask()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ]);

        // Tambahkan poin ke pengguna
        $this->user->addPoints($this->task->points);
    }

    public function scopeCheckExpired($query)
    {
        $query->where('status', 'incomplete')
            ->whereHas('task', function ($q) {
                $q->where('deadline', '<', now());
            })
            ->update(['status' => 'expired']);
    }

    // Hapus tugas yang expired lebih dari 7 hari
    public function scopeDeleteExpired($query)
    {
        $query->where('status', 'expired')
            ->where('updated_at', '<', now()->subDays(3))
            ->delete();
    }
}
