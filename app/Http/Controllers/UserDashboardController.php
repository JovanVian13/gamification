<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\VoucherRedemption;
use App\Models\User;
use App\Models\UserTask;

class UserDashboardController extends Controller
{
    // Dashboard utama
    public function index()
    {
        $user = Auth::user();

        // Ambil leaderboard
        $leaderboard = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.profile_picture', 'users.name', \DB::raw('SUM(points.points) as total_points'))
            ->groupBy('users.id', 'users.name', 'users.profile_picture')
            ->orderByDesc('total_points')
            ->take(3)
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
    
        $rank = $rank !== false ? $rank + 1 : null; // Ranking dimulai dari 1

        // Ambil tugas pengguna
        $userTasks = UserTask::with('task')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->orderBy('status', 'asc')
            ->take(3) // Ambil maksimal 3 tugas
            ->get();

        // Data untuk dashboard
        $data = [
            'totalPoints' => $user->points ?? 0, // Total poin pengguna
            'tasks' => $userTasks, // Masukkan tugas ke data
            'rank' => $rank, // Masukkan tugas ke data
        ];

        // Kirim data ke view
        return view('user.dashboard', compact('data', 'leaderboard'));
    }

    // Profil pengguna
    public function showProfile()
    {
        $user = Auth::user();

        // Data untuk profil
        $completedTasksCount = UserTask::where('user_id', $user->id)->where('status', 'completed')->count();
        $inProgressTasksCount = UserTask::where('user_id', $user->id)->where('status', 'in-progress')->count();
        $totalRedemptionCount = VoucherRedemption::where('user_id', $user->id)->count();

        return view('user.profil', compact(
            'user',
            'completedTasksCount',
            'inProgressTasksCount',
            'totalRedemptionCount'
        ));
    }
}
