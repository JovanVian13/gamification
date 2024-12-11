<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LeaderBoardController extends Controller
{
    // Show leaderboard
    public function showLeaderboard(Request $request)
    {
        $period = $request->input('period', 'weekly');
        $user = Auth::user();

        // Ambil leaderboard dengan join tabel points
        $leaderboard = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', 'users.name', \DB::raw('SUM(points.points) as points'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('points')
            ->take(10)
            ->get();

        // Hitung total poin untuk setiap pengguna
        $userRankQuery = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', \DB::raw('SUM(points.points) as total_points'))
            ->groupBy('users.id')
            ->orderByDesc('total_points');

        $userRankings = $userRankQuery->get();

        // Cari ranking pengguna saat ini
        $rank = $userRankings->search(function ($item) use ($user) {
            return $item->id == $user->id;
        });
    
        $rank = $rank !== false ? $rank + 1 : null;

        $userBadges = auth()->user()->badges;

        // Kirim data ke view
        return view('user.leaderboard', compact('leaderboard', 'period', 'userBadges', 'rank'));
    }
}
