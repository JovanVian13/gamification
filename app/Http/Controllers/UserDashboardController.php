<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\VoucherRedemption;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Actual data for the dashboard
        $data = [
            'totalPoints' => 150, // Set the actual points here
            'leaderboard' => [
                ['name' => 'User 1', 'points' => 200],
                ['name' => 'User 2', 'points' => 150],
            ],
            'tasks' => [
                ['title' => 'Task 1', 'priority' => true, 'deadline' => '2024-11-30'],
                ['title' => 'Task 2', 'priority' => false, 'deadline' => '2024-12-01'],
            ]
        ];

        // Return the view and pass data
        return view('user.dashboard', compact('data'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        
        // Example data
        $completedTasksCount = Task::where('user_id', $user->id)->where('status', 'completed')->count();
        $inProgressTasksCount = Task::where('user_id', $user->id)->where('status', 'in-progress')->count();
        $totalPoints = $user->total_points; // Assuming this is a column or a computed field
        $totalRedemptionCount = VoucherRedemption::where('user_id', $user->id)->count();

        return view('user.profil', compact('completedTasksCount', 'inProgressTasksCount', 'totalPoints', 'totalRedemptionCount'));
    }

}


