<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTask;
use App\Models\VoucherRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    public function index()
    {
        try {
            // Statistik Pengguna
            $dailyUsers = User::whereDate('last_login', now()->toDateString())->count();
            $weeklyUsers = User::whereBetween('last_login', [now()->startOfWeek(), now()->endOfWeek()])->count();
            $monthlyUsers = User::whereMonth('last_login', now()->month)->count();

            // Tren Pendaftaran Pengguna
            $newUsers = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            // Statistik Tugas
            $taskStats = UserTask::with(['task', 'user'])
                ->select('task_id', DB::raw('COUNT(*) as total_completions'))
                ->where('status', 'completed')
                ->groupBy('task_id')
                ->orderBy('total_completions', 'desc')
                ->get();

            // Statistik Voucher
            $voucherStats = VoucherRedemption::select('voucher_id', DB::raw('COUNT(*) as total_redemptions'))
                ->groupBy('voucher_id')
                ->orderBy('total_redemptions', 'desc')
                ->get();

            return view('admin.report', compact(
                'dailyUsers', 'weeklyUsers', 'monthlyUsers',
                'newUsers', 'taskStats', 'voucherStats'
            ));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load report data: ' . $e->getMessage()]);
        }
    }

    public function exportCSV()
    {
        try {
            return Excel::download(new ReportExport, 'report.csv');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to export report to CSV: ' . $e->getMessage()]);
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new ReportExport, 'report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to export report to Excel: ' . $e->getMessage()]);
        }
    }
}
