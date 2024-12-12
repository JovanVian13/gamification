<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminLeaderBoardController extends Controller
{
    // Show leaderboard
    public function showLeaderboard(Request $request)
    {
        $period = $request->input('period', 'weekly');

        // Ambil leaderboard
        $leaderboard = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.name', \DB::raw('SUM(points.points) as points'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('points')
            ->take(10)
            ->get();

        // Kirim data ke view
        return view('admin.leaderboard', compact('leaderboard', 'period'));
    }
}
