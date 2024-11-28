<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTasks extends Model
{
    // Nama tabel jika menggunakan nama selain konvensi
    protected $table = 'user_tasks';

    // Tentukan kolom-kolom yang dapat diisi
    protected $fillable = ['user_id', 'task_id', 'status'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi ke tabel users
    }

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id'); // Relasi ke tabel tasks
    }
}
