<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Daftar Tugas
    public function index()
    {
        // Ambil semua tugas dari database
        $tasks = Task::all();
        return view('user.task', compact('tasks'));
    }

    // Menyelesaikan Tugas
    public function completeTask($id)
    {
        // Cari tugas berdasarkan ID
        $task = Task::find($id);

        if (!$task) {
            return back()->with('error', "Tugas dengan ID {$id} tidak ditemukan.");
        }

        // Simulasi perubahan status tugas
        $task->status = 'completed'; // Pastikan Anda memiliki kolom status di tabel tasks
        $task->save();

        return back()->with('success', "Tugas dengan ID {$id} berhasil diselesaikan!");
    }
}
