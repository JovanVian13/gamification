<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskManage;
use App\Models\UserTask;
use App\Models\User;

class TaskManageController extends Controller
{
    // Tampilkan semua tugas
    public function manageTasks()
    {
        $tasks = TaskManage::paginate(10); // Menampilkan 10 tugas per halaman
        return view('admin.taskmanage', compact('tasks'));
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
            'users' => 'nullable|array', // Jika kosong, berarti untuk semua pengguna.
            'users.*' => 'exists:users,id',
        ]);

        // Buat tugas
        $task = TaskManage::create([
            'title' => $request->title,
            'type' => $request->type,
            'points' => $request->points,
            'url' => $request->url,
            'deadline' => $request->deadline,
            'created_by' => auth()->id(),
        ]);

        // Jika ada `users`, hubungkan tugas ke pengguna tersebut
        if ($request->users) {
            foreach ($request->users as $userId) {
                UserTask::create([
                    'user_id' => $userId,
                    'task_id' => $task->id,
                ]);
            }
        } else {
            // Jika tidak ada `users`, hubungkan ke semua pengguna
            $users = User::all();
            foreach ($users as $user) {
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }
        }

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully.');
    }

    public function assignTasksToNewUsers()
    {
        $tasks = TaskManage::all();

        foreach ($tasks as $task) {
            // Cari pengguna yang belum menerima tugas ini
            $users = User::whereDoesntHave('userTasks', function ($query) use ($task) {
                $query->where('task_id', $task->id);
            })->get();

            foreach ($users as $user) {
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }
        }
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
            'assign_to' => 'required|string',
            'url' => 'nullable|url',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task updated successfully.');
    }

    // Hapus tugas
    public function deleteTask($id)
    {
        $task = TaskManage::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully.');
    }
}
