<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Spatie\Permission\Models\Role;

class SecurityLogController extends Controller
{
    public function index()
    {
        // Ambil logs aktivitas dan roles
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::all(); // Mengambil semua roles untuk ditampilkan

        return view('admin.security', compact('logs', 'roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        Role::create(['name' => $request->name]);

        return back()->with('success', 'Role berhasil ditambahkan.');
    }

    public function deleteRole(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh pengguna.');
        }

        $role->delete();

        return back()->with('success', 'Role berhasil dihapus.');
    }
}
