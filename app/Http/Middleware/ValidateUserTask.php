<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserTask;

class ValidateUserTask
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil parameter task_id dari request
        $userTaskId = $request->query('task_id');

        // Cari UserTask berdasarkan ID
        $userTask = UserTask::find($userTaskId);

        // Validasi: pastikan task ada dan belum selesai
        if (!$userTask || $userTask->status === 'completed') {
            return redirect()->route('usertask')->with('error', 'Invalid or completed task');
        }

        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}
