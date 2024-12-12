<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Task;

class LeaderBoardController extends Controller
{
    // Show leaderboard
    public function showLeaderboard(Request $request)
    {
        $period = $request->input('period', 'weekly');
        $user = Auth::user();

        // Ambil leaderboard dengan join tabel points dan frekuensi tugas
        $leaderboard = User::leftJoinSub(
            \DB::table('points')
                ->select('user_id', \DB::raw('SUM(points) as points'))
                ->groupBy('user_id')
                ->having('points', '>', 0),
            'user_points',
            'users.id',
            '=',
            'user_points.user_id'
        )
        ->leftJoinSub(
            \DB::table('user_tasks')
                ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
                ->select(
                    'user_tasks.user_id',
                    \DB::raw('COUNT(user_tasks.id) as total_tasks'),
                    \DB::raw('SUM(CASE WHEN user_tasks.status = "completed" AND tasks.type = "video" THEN 1 ELSE 0 END) as watch_frequency'),
                    \DB::raw('SUM(CASE WHEN user_tasks.status = "completed" AND tasks.type = "like" THEN 1 ELSE 0 END) as like_frequency'),
                    \DB::raw('SUM(CASE WHEN user_tasks.status = "completed" AND tasks.type = "share" THEN 1 ELSE 0 END) as share_frequency'),
                    \DB::raw('SUM(CASE WHEN user_tasks.status = "completed" AND tasks.type = "comment" THEN 1 ELSE 0 END) as comment_frequency')
                )
                ->where('user_tasks.status', 'completed') // Filter hanya status completed
                ->groupBy('user_tasks.user_id'),
            'task_summary',
            'users.id',
            '=',
            'task_summary.user_id'
        )
        ->select(
            'users.id',
            'users.name',
            'user_points.points',
            'task_summary.total_tasks',
            'task_summary.watch_frequency',
            'task_summary.like_frequency',
            'task_summary.share_frequency',
            'task_summary.comment_frequency'
        )
        ->whereNotNull('user_points.points')
        ->where('user_points.points', '>', 0)
        ->orderByDesc('user_points.points')
        ->take(10)
        ->get();
    
        // Hitung total poin untuk setiap pengguna
        $userRankQuery = User::join('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', \DB::raw('SUM(points.points) as total_points'))
            ->groupBy('users.id')
            ->having('total_points', '>', 0)
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
