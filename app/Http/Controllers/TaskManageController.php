<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskManage;
use App\Models\UserTask;
use App\Models\User;
use App\Models\Task;

class TaskManageController extends Controller
{
    // Tampilkan semua tugas
    public function manageTasks()
    {
        $tasks = TaskManage::paginate(10);
        $users = User::all();
        return view('admin.taskmanage', compact('tasks', 'users'));
    }

    // Tampilkan form tambah tugas
    public function createTask()
    {
        // Ambil semua pengguna dari database
        $users = User::all();

        // Kirim data ke view
        return view('admin.taskcreate', compact('users'));
    }


    // Simpan tugas baru
    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,like,comment,share',
            'points' => 'required|integer|min:1',
            'url' => 'nullable|url',
            'deadline' => 'nullable|date',
        ]);

        // Buat tugas baru
        TaskManage::create([
            'title' => $request->title,
            'type' => $request->type,
            'points' => $request->points,
            'url' => $request->url,
            'deadline' => $request->deadline,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully. Please assign it to users.');
    }

    public function assignTasksToNewUsers()
    {
        TaskManage::chunk(50, function ($tasks) {
            foreach ($tasks as $task) {
                $newUsers = User::where('role', '!=', 'admin')
                    ->whereDoesntHave('userTasks', function ($query) use ($task) {
                        $query->where('task_id', $task->id);
                    })->pluck('id');

                $taskAssignments = $newUsers->map(function ($userId) use ($task) {
                    return [
                        'user_id' => $userId,
                        'task_id' => $task->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });

                UserTask::insert($taskAssignments->toArray());
            }
        });

        return redirect()->back()->with('success', 'Tasks assigned to new non-admin users successfully.');
    }

    // Tampilkan form edit tugas
    public function editTask($id)
    {
        $task = TaskManage::with('users')->findOrFail($id);
        $users = User::all();
        
        return view('admin.taskedit', compact('task', 'users'));
    }

    // Update tugas
    public function updateTask(Request $request, $id)
    {
        $task = TaskManage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,like,comment,share',
            'points' => 'required|integer|min:1',
            'url' => 'nullable|url',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task updated successfully.');
    }

    public function assignTask(Request $request, TaskManage $task)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        if ($request->user_id === 'all') {
            // Assign task to all users who don't have it yet
            $users = User::whereDoesntHave('userTasks', function ($query) use ($task) {
                $query->where('task_id', $task->id);
            })->get();

            foreach ($users as $user) {
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }

            return redirect()->route('admin.tasks')->with('success', 'Task assigned to all users successfully.');
        }

        // Assign task to a specific user
        $user = User::findOrFail($request->user_id);

        if ($user->userTasks->where('task_id', $task->id)->isNotEmpty()) {
            return redirect()->route('admin.tasks')->with('error', 'Task already assigned to this user.');
        }

        UserTask::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        return redirect()->route('admin.tasks')->with('success', 'Task assigned to user successfully.');
    }


    // Hapus tugas
    public function deleteTask($id)
    {
        $task = TaskManage::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully.');
    }

    public function taskManagement()
    {
        $tasks = Task::withCount(['userTasks as assigned_count', 'completedTasks as completed_count'])->paginate(10);
        $users = User::all();
        return view('admin.taskmanagement', compact('tasks', 'users'));
    }

}
