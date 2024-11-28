<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Daftar Tugas
    public function index()
    {
        // Ambil tugas berdasarkan pengguna yang login
        $tasks = auth()->user()->tasks;

        return view('user.task', compact('tasks'));
    }

    // Menyelesaikan Tugas
    public function completeTask($id)
    {
        $user = auth()->user();
        $userTask = $user->tasks()->where('task_id', $id)->first();

        if (!$userTask) {
            return back()->with('error', "Tugas dengan ID {$id} tidak ditemukan untuk pengguna ini.");
        }

        if ($userTask->pivot->status === 'completed') {
            return back()->with('info', "Tugas dengan ID {$id} sudah selesai.");
        }

        // Perbarui status menjadi completed
        $user->tasks()->updateExistingPivot($id, [
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', "Tugas dengan ID {$id} berhasil diselesaikan!");
    }
}
