<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Voucher;

class ReportController extends Controller
{
    public function index()
    {
        // Tren Pendaftaran
        $newUsers = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        // Statistik Tugas
        $taskStats = Task::withCount('completions')->orderBy('completions_count', 'desc')->get();

        // Statistik Voucher
        $voucherStats = Voucher::withCount('redemptions')->orderBy('redemptions_count', 'desc')->get();

        return view('admin.report', compact( 
            'newUsers', 'taskStats', 'voucherStats'
        ));
    }
}
