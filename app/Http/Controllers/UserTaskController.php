<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTask;
use App\Models\Points;
use App\Models\Notification;
use App\Helpers\UserActivityHelper;

class UserTaskController extends Controller
{
    // Menampilkan daftar tugas pengguna
    public function index()
    {
        $userTasks = UserTask::with('task')
            ->where('user_id', auth()->id())
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('user.task', compact('userTasks'));
    }

    public function trackInteraction(Request $request)
    {
        $taskId = $request->input('task_id');
        $eventType = $request->input('event_type');

        // Jika event_type adalah 'completed', tandai tugas sebagai selesai
        if ($eventType === 'completed') {
            $userTask = UserTask::find($taskId);

            if ($userTask && $userTask->status === 'incomplete') {
                // Menandai tugas sebagai selesai
                $userTask->status = 'completed';
                $userTask->completed_at = now();
                $userTask->save();

                // Tambahkan poin ke tabel points
                Points::create([
                    'user_id' => $userTask->user_id,
                    'points' => $userTask->task->points,
                    'period' => 'daily',
                    'date' => now()->toDateString(),
                ]);

                // Tambahkan poin ke pengguna
                $user = $userTask->user;
                if ($user) {
                    $user->increment('points', $userTask->task->points);
                }
            }
        }

        // Buat notifikasi
        Notification::create([
            'user_id' => $userTask->user_id,
            'title' => 'Task Completed',
            'message' => 'You have completed the task: ' . $userTask->task->title,
            'read_status' => 'unread',
        ]);

        // Kembalikan response JSON
        return response()->json(['message' => 'Interaction tracked successfully']);
    }

    // Menyelesaikan tugas
    public function markAsComplete($id)
    {
        $userTask = UserTask::findOrFail($id);

        if ($userTask->status !== 'completed') {
            $userTask->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        Points::create([
            'user_id' => $userTask->user_id,
            'points' => $userTask->task->points,
            'period' => 'daily',
            'date' => now()->toDateString(),
        ]);

        $user = $userTask->user;
        if ($user) {
            $user->increment('points', $userTask->task->points);
        }

        UserActivityHelper::log($user->id, 'task_completed', $userTask->task->type, $userTask->task->points);

        // Buat notifikasi
        Notification::create([
            'user_id' => $userTask->user_id,
            'title' => 'Task Completed',
            'message' => 'You have completed the task: ' . $userTask->task->title,
            'read_status' => 'unread',
        ]);

        return redirect()->route('usertask')->with('success', 'Task marked as completed!');
    }
}

