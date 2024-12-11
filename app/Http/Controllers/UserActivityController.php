<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;

class UserActivityController extends Controller
{
    // Tampilkan halaman aktivitas pengguna (tabel)
    public function index()
    {
        $activities = UserActivity::with('user')->latest()->paginate(20);

        return view('admin.useractivity', compact('activities'));
    }

    // Endpoint untuk data grafik
    public function activityChartData()
    {
        // Data untuk grafik "Task Completed"
        $taskData = UserActivity::where('activity_type', 'task_completed')
            ->selectRaw('activity_detail, COUNT(*) as count')
            ->groupBy('activity_detail')
            ->pluck('count', 'activity_detail');

        // Data untuk grafik "Point Conversion"
        $conversionData = UserActivity::where('activity_type', 'point_conversion')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return response()->json([
            'tasks' => $taskData,
            'conversions' => $conversionData,
        ]);
    }
}