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
        
        // Example data: replace with actual logic to get user's statistics
        $completedTasksCount = Task::where('user_id', $user->id)->where('status', 'completed')->count();
        $inProgressTasksCount = Task::where('user_id', $user->id)->where('status', 'in-progress')->count();
        $totalPoints = $user->total_points; // Assuming this field exists or is calculated
        $totalRedemptionCount = VoucherRedemption::where('user_id', $user->id)->count();

        return view('user.profile', compact('completedTasksCount', 'inProgressTasksCount', 'totalPoints', 'totalRedemptionCount'));
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
