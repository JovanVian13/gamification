<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\VoucherRedemption;

class ProfileController extends Controller
{
    // Display the user's profile page
    public function showProfile()
    {
        $user = Auth::user();

        // Ambil statistik tugas menggunakan tabel pivot user_tasks
        $completedTasksCount = $user->tasks()->wherePivot('status', 'completed')->count();
        $inProgressTasksCount = $user->tasks()->wherePivot('status', 'in-progress')->count();

        $totalPoints = $user->points; // Pastikan kolom points ada di tabel users

        return view('user.profile', compact('completedTasksCount', 'inProgressTasksCount', 'totalPoints'));
    }


    // Show the profile edit form
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user')); // Create an edit-profile view
    }

    // Update the user's profile information
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            // Add validation rules for other fields here
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email'])); // Update other fields as necessary

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
