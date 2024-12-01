<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManage;
use App\Models\TaskManage;
use App\Models\VoucherManage;
use App\Models\UserTask;
use App\Models\User;

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
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = UserManage::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
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

    // 1. Menampilkan daftar voucher
    public function manageVoucher()
    {
        $vouchers = VoucherManage::orderBy('created_at', 'desc')->get();
        return view('admin.vouchermanage', compact('vouchers'));
    }

    // 2. Form untuk membuat voucher baru
    public function createVoucher()
    {
        return view('admin.vouchercreate');
    }

    // 3. Menyimpan voucher baru
    public function storeVoucher(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
        ]);

        VoucherManage::create([
            'title' => $request->title,
            'description' => $request->description,
            'points_required' => $request->points_required,
            'code' => strtoupper(uniqid('VC')), // Membuat kode unik dengan prefix "VC"
            'status' => 'active',
        ]);

        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil dibuat.');
    }

    // 4. Form untuk mengedit voucher
    public function editVoucher(VoucherManage $voucher)
    {
        return view('admin.voucheredit', compact('voucher'));
    }

    // 5. Memperbarui voucher
    public function updateVoucher(Request $request, VoucherManage $voucher)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'status' => 'required|in:active,expired',
        ]);

        $voucher->update($request->all());

        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil diperbarui.');
    }

    // 6. Menghapus voucher
    public function deleteVoucher(VoucherManage $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil dihapus.');
    }
}
