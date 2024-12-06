<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\UserTask;
use App\Models\VoucherRedemption;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    // Display the user's profile page
    public function showProfile()
    {
        $user = Auth::user();
        
        // Example data: replace with actual logic to get user's statistics
        $completedTasksCount = UserTask::where('user_id', $user->id)->where('status', 'completed')->count();
        $inProgressTasksCount = UserTask::where('user_id', $user->id)->where('status', 'in-progress')->count();
        $totalPoints = $user->total_points; // Assuming this field exists or is calculated
        $totalRedemptionCount = VoucherRedemption::where('user_id', $user->id)->count();
        $totalPointCount = VoucherRedemption::where('user_id', $user->id)->sum('points_used');
        $statistics = [
            'video' => [
                'completed' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'video'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'video'))
                    ->where('status', 'incomplete')->count(),
            ],
            'like' => [
                'completed' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'like'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'like'))
                    ->where('status', 'incomplete')->count(),
            ],
            'comment' => [
                'completed' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'comment'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'comment'))
                    ->where('status', 'incomplete')->count(),
            ],
            'share' => [
                'completed' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'share'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $user->id)
                    ->whereHas('task', fn($query) => $query->where('type', 'share'))
                    ->where('status', 'incomplete')->count(),
            ],
        ];
        return view('user.profile', compact('completedTasksCount', 'inProgressTasksCount', 'totalPoints', 'totalRedemptionCount', 'totalPointCount', 'statistics'));
    }

    // Show the profile edit form
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user')); // Create an edit-profile view
    }

    // Update the user's profile information
    // Update the user's profile information
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // Log aktivitas edit profil
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Updated profile information',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'age' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048', // Validate image file
        ]);

        $user = Auth::user();

        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->age = $request->input('age');
        $user->location = $request->input('location');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Store the file and get the path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
    
            // Optionally delete the old profile picture if needed
            if ($user->profile_picture && \Storage::exists('public/' . $user->profile_picture)) {
                \Storage::delete('public/' . $user->profile_picture);
            }
    
            // Update the user's profile picture path
            $user->profile_picture = $path;
        }

        $user->save(); // Save updated user info

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }   
}