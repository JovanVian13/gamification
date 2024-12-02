<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeaderBoardController extends Controller
{
    // Show leaderboard
    public function showLeaderboard(Request $request)
    {
        $period = $request->input('period', 'weekly'); // Default period

        // Ambil leaderboard dengan join tabel points
        $leaderboard = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', 'users.name', \DB::raw('SUM(points.points) as points'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('points')
            ->take(10)
            ->get();

        
        $userBadges = auth()->user()->badges;

        // Kirim data ke view
        return view('user.leaderboard', compact('leaderboard', 'period', 'userBadges'));
    }
}
