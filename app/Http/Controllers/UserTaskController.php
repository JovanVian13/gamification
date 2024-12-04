<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTask;
use App\Models\Task;
use App\Models\Points;
use App\Services\YouTubeService;
use GuzzleHttp\Client;


class UserTaskController extends Controller
{
    // Menampilkan daftar tugas pengguna
    public function index()
    {
        // Ambil semua tugas yang terkait dengan pengguna saat ini
        $userTasks = UserTask::with('task')
            ->where('user_id', auth()->id()) // Tugas hanya untuk user yang sedang login
            ->get();

        // Pastikan `userTasks` dikirim ke view
        return view('user.task', compact('userTasks'));
    }

    public function trackInteraction(Request $request)
    {
        $taskId = $request->input('task_id');
        $eventType = $request->input('event_type');

        $userTask = UserTask::findOrFail($taskId);
        
        if ($eventType === 'watched' && $userTask->status === 'incomplete') {
            $userTask->update(['status' => 'completed']);
            return response()->json(['message' => 'Video completed']);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    // Menyelesaikan tugas
    public function markAsComplete($id)
    {
        // Cari UserTask berdasarkan ID
        $userTask = UserTask::findOrFail($id);
    
        // Pastikan status masih pending sebelum mengubah
        if ($userTask->status !== 'completed') {
            $userTask->update(['status' => 'completed']);
        }
    
        // Tambahkan poin ke tabel points
        Points::create([
            'user_id' => $userTask->user_id,
            'points' => $userTask->task->points,
            'period' => 'daily', // Atur period sesuai logika Anda
            'date' => now()->toDateString(),
        ]);
    
        // **Perbaikan di sini**: Tambahkan poin ke tabel users
        $user = $userTask->user; // Ambil user yang terkait dengan userTask
        if ($user) {
            $user->increment('points', $userTask->task->points);
        }

    
        // Redirect kembali ke halaman My Tasks dengan pesan sukses
        return redirect()->route('usertask')->with('success', 'Task marked as completed!');
    }
    
    public function redirectToGoogle()
    {
        $queryParams = http_build_query([
            'client_id' => config('services.youtube.client_id'),
            'redirect_uri' => config('services.youtube.redirect_uri'),
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/youtube.readonly',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/auth?' . $queryParams);
    }

    public function handleGoogleCallback(Request $request)
    {
        $http = new Client();

        try {
            $response = $http->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'code' => $request->code,
                    'client_id' => config('services.youtube.client_id'),
                    'client_secret' => config('services.youtube.client_secret'),
                    'redirect_uri' => config('services.youtube.redirect_uri'),
                    'grant_type' => 'authorization_code',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Simpan access token di sesi atau database
            session(['google_access_token' => $data['access_token']]);

            return redirect()->route('user.tasks')->with('success', 'Google account linked successfully!');
        } catch (\Exception $e) {
            return redirect()->route('user.tasks')->with('error', 'Failed to authenticate with Google.');
        }
    }

    public function checkLikeStatus($taskId)
    {
        $userTask = UserTask::with('task')->findOrFail($taskId);

        $accessToken = session('google_access_token'); // Ambil access token pengguna
        if (!$accessToken) {
            return redirect()->route('google.auth')->with('error', 'Please link your Google account first.');
        }

        $youtubeService = new YouTubeService();
        $likeCount = $youtubeService->checkVideoLike($userTask->task->video_id, $accessToken);

        if ($likeCount > 0) {
            // Tandai tugas selesai jika like ditemukan
            $userTask->update(['status' => 'completed']);
            return redirect()->route('user.tasks')->with('success', 'Task completed!');
        } else {
            return redirect()->route('user.tasks')->with('error', 'Like not detected.');
        }
    }

}
