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
    // Ambil pengguna yang sedang login
    $user = auth()->user();

    // Cek apakah tugas tersebut milik pengguna
    $userTask = $user->tasks()->where('task_id', $id)->first(); // Cek tugas yang terkait

    // Jika tugas tidak ditemukan
    if (!$userTask) {
        return back()->with('error', "Tugas dengan ID {$id} tidak ditemukan untuk pengguna ini.");
    }

    // Jika tugas sudah selesai
    if ($userTask->pivot->status === 'completed') {
        return back()->with('info', "Tugas dengan ID {$id} sudah selesai.");
    }

    // Perbarui status tugas menjadi completed
    $user->tasks()->updateExistingPivot($id, [
        'status' => 'completed',         // Status tugas menjadi selesai
        'completed_at' => now(),         // Waktu penyelesaian tugas
    ]);

    // Kembalikan pesan sukses
    return back()->with('success', "Tugas dengan ID {$id} berhasil diselesaikan!");
}
}
