<?php

namespace App\Http\Controllers;

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
}


