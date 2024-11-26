<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
    public function index()
    {
        $data = [
            'leaderboard' => [
                ['name' => 'John Doe', 'points' => 1200],
                ['name' => 'Jane Smith', 'points' => 1100],
                ['name' => 'Bob Johnson', 'points' => 950],
                ['name' => 'Alice Brown', 'points' => 900],
            ],
            'badges' => [
                [
                    'image' => 'https://via.placeholder.com/80',
                    'title' => 'Top Scorer',
                    'description' => 'Awarded for achieving the highest points.',
                ],
                [
                    'image' => 'https://via.placeholder.com/80',
                    'title' => 'Task Master',
                    'description' => 'Awarded for completing 50 tasks.',
                ],
                [
                    'image' => 'https://via.placeholder.com/80',
                    'title' => 'Consistency Champ',
                    'description' => 'Awarded for logging in 30 days in a row.',
                ],
            ],
            'stats' => [
                'totalPoints' => 1200,
                'tasksCompleted' => 75,
            ],
            'targets' => [
                ['description' => 'Achieve 1500 points', 'progress' => 80],
                ['description' => 'Complete 100 tasks', 'progress' => 75],
                ['description' => 'Earn 5 badges', 'progress' => 60],
            ],
        ];

        return view('leaderboard', compact('data'));
    }

}
