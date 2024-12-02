<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTask;
use App\Models\Task;
use App\Models\Points;

class UserTaskController extends Controller
{
    // Menampilkan daftar tugas pengguna
    public function index()
    {
        // Ambil semua tugas yang terkait dengan pengguna saat ini
        $userTasks = UserTask::with('task')
            ->where('user_id', auth()->id()) // Tugas hanya untuk user yang sedang login
            ->get();

        // Pastikan `userTasks` dikirim ke view
        return view('user.task', compact('userTasks'));
    }


    // Menyelesaikan tugas
    public function markAsComplete($id)
    {
        // Cari UserTask berda  sarkan ID
        $userTask = UserTask::findOrFail($id);

        // Pastikan status masih pending sebelum mengubah
        if ($userTask->status !== 'completed') {
            $userTask->update(['status' => 'completed']);
        }

         // Tambahkan poin ke tabel points
         Points::create([
            'user_id' => $userTask->user_id,
            'points' => $userTask->task->points,
            'period' => 'daily', // Atur period sesuai logika Anda
            'date' => now()->toDateString(),
        ]);

        // Redirect kembali ke halaman My Tasks dengan pesan sukses
        return redirect()->route('usertask')->with('success', 'Task marked as completed!');
    }

}
