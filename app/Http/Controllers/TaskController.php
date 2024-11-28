<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Simulasi Data Dummy
    private $tasks = [
        ['id' => 1, 'title' => 'Tonton Video 1', 'type' => 'video', 'points' => 50, 'status' => 'incomplete'],
        ['id' => 2, 'title' => 'Berikan Like pada Post', 'type' => 'like', 'points' => 20, 'status' => 'incomplete'],
        ['id' => 3, 'title' => 'Komentar pada Video', 'type' => 'comment', 'points' => 30, 'status' => 'completed'],
        ['id' => 4, 'title' => 'Bagikan Konten', 'type' => 'share', 'points' => 40, 'status' => 'incomplete'],
        ['id' => 1, 'title' => 'Tonton Video 1', 'type' => 'video', 'points' => 50, 'status' => 'incomplete'],
        ['id' => 2, 'title' => 'Berikan Like pada Post', 'type' => 'like', 'points' => 20, 'status' => 'incomplete'],
        ['id' => 3, 'title' => 'Komentar pada Video', 'type' => 'comment', 'points' => 30, 'status' => 'completed'],
        ['id' => 4, 'title' => 'Bagikan Konten', 'type' => 'share', 'points' => 40, 'status' => 'incomplete'],
        ['id' => 1, 'title' => 'Tonton Video 1', 'type' => 'video', 'points' => 50, 'status' => 'incomplete'],
        ['id' => 2, 'title' => 'Berikan Like pada Post', 'type' => 'like', 'points' => 20, 'status' => 'incomplete'],
        ['id' => 3, 'title' => 'Komentar pada Video', 'type' => 'comment', 'points' => 30, 'status' => 'completed'],
        ['id' => 4, 'title' => 'Bagikan Konten', 'type' => 'share', 'points' => 40, 'status' => 'incomplete'],
    ];

    // Menampilkan Daftar Tugas
    public function index()
    {
        $data['tasks'] = $this->tasks; // Simpan data tugas ke dalam array untuk view
        return view('task', compact('data'));
    }

    // Menyelesaikan Tugas
    public function completeTask($id)
    {
        // Simulasi penyelesaian tugas
        return back()->with('success', "Tugas dengan ID {$id} berhasil diselesaikan!");
    }
}
