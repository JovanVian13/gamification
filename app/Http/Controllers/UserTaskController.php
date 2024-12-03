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

    public function trackInteraction(Request $request)
    {
        $taskId = $request->input('task_id');
        $eventType = $request->input('event_type');

        // Save interaction logic
        if ($eventType === 'completed') {
            $userTask = UserTask::find($taskId);
            if ($userTask && $userTask->status === 'incomplete') {
                $userTask->status = 'completed';
                $userTask->save();
            }
        }

        return response()->json(['message' => 'Interaction tracked successfully']);
    }

    // Menyelesaikan tugas
    public function markAsComplete($id)
    {
        // Cari UserTask berdasarkan ID
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
    
        // **Perbaikan di sini**: Tambahkan poin ke tabel users
        $user = $userTask->user; // Ambil user yang terkait dengan userTask
        $user->increment('points', $userTask->task->points); // Menambahkan poin ke kolom 'points' di tabel users
    
        // Redirect kembali ke halaman My Tasks dengan pesan sukses
        return redirect()->route('usertask')->with('success', 'Task marked as completed!');
    }
    

}
