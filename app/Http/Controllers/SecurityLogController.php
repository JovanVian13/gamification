<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class SecurityLogController extends Controller
{
    public function index()
    {
        // Ambil logs aktivitas
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Ambil pengguna yang sedang online (last login dalam 10 menit terakhir)
        $onlineUsers = User::where('last_login', '>=', Carbon::now()->subMinutes(10))->get();

        return view('admin.security', compact('logs', 'onlineUsers'));
    }
}
