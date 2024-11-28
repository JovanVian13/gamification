<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManage;
use App\Models\TaskManage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Example data
        $data = ['key' => 'admin value']; // Replace with actual admin data

        // Return the view and pass data
        return view('admin.dashboard', compact('data'));
    }

    public function manageUsers()
    {
        $users = UserManage::paginate(10); // Paginate user list (10 users per page)
        return view('admin.usermanage', compact('users'));
    }

    public function editUser($id)
    {
        $user = UserManage::findOrFail($id); // Find user or fail if not found
        return view('admin.useredit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = UserManage::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'is_active' => 'required|boolean',
        ]);

        $user->update($request->only(['name', 'email', 'is_active']));

        return redirect()->route('admin.usermanage')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = UserManage::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.usermanage')->with('success', 'User deleted successfully.');
    }

    // Tampilkan semua tugas
    public function manageTasks()
    {
        $tasks = TaskManage::paginate(10); // Menampilkan 10 tugas per halaman
        return view('admin.taskmanage', compact('tasks'));
    }

    // Tampilkan form tambah tugas
    public function createTask()
    {
        return view('admin.taskcreate');
    }

    // Simpan tugas baru
    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,like,comment,share',
            'points' => 'required|integer|min:1',
            'url' => 'nullable|url',
            'deadline' => 'nullable|datetimes',
        ]);

        TaskManage::create($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully.');
    }

    // Tampilkan form edit tugas
    public function editTask($id)
    {
        $task = TaskManage::findOrFail($id);
        return view('admin.taskedit', compact('task'));
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
            'deadline' => 'nullable|datetimes',
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
