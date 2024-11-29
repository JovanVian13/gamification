<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Badge;
use App\Models\Point;

class AdminLeaderBoardController extends Controller
{
    // Show leaderboard
    public function showLeaderboard(Request $request)
    {
        $period = $request->input('period', 'weekly'); // Default period

        // Ambil leaderboard dengan join tabel points
        $leaderboard = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.name', \DB::raw('SUM(points.points) as points')) // Total poin
            ->groupBy('users.id', 'users.name') // Grup berdasarkan ID dan nama
            ->orderByDesc('points') // Urutkan dari poin tertinggi
            ->take(10) // Ambil 10 teratas
            ->get();

        // Kirim data ke view
        return view('admin.leaderboard', compact('leaderboard', 'period'));
    }
}
