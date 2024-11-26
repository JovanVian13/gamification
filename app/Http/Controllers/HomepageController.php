<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $data = [
            'totalPoints' => 1250,
            'tasks' => [
                ['title' => 'Tonton Video A', 'priority' => true, 'deadline' => '2024-11-30'],
                ['title' => 'Berikan Like pada Postingan', 'priority' => false],
            ],
            'leaderboard' => [
                ['name' => 'John Doe', 'points' => 5000],
                ['name' => 'Jane Smith', 'points' => 4500],
                ['name' => 'Alan Walker', 'points' => 4300],
            ],
            'notifications' => [
                'Tugas "Tonton Video A" hampir selesai.',
                'Selamat, Anda telah menyelesaikan 50 tugas!',
            ],
        ];

        // Pastikan view menerima $data
        return view('homepage', compact('data'));
    }
}
