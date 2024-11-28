<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManage;

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

}
