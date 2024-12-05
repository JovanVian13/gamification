<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistik tugas berdasarkan status
        $statistics = [
            'video' => [
                'completed' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'video'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'video'))
                    ->where('status', 'incomplete')->count(),
            ],
            'like' => [
                'completed' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'like'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'like'))
                    ->where('status', 'incomplete')->count(),
            ],
            'comment' => [
                'completed' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'comment'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'comment'))
                    ->where('status', 'incomplete')->count(),
            ],
            'share' => [
                'completed' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'share'))
                    ->where('status', 'completed')->count(),
                'incomplete' => UserTask::where('user_id', $userId)
                    ->whereHas('task', fn($query) => $query->where('type', 'share'))
                    ->where('status', 'incomplete')->count(),
            ],
        ];

        return view('user.profile', compact('statistics'));
    }
}
