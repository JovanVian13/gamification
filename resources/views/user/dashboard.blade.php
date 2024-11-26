@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Informasi Poin Total -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Poin Anda</h2>
        <p class="text-4xl font-bold text-indigo-600">{{ $data['totalPoints'] }}</p>
    </div>

    <!-- Tugas Harian & Baru -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tugas Harian & Baru</h2>
        <ul>
            @foreach ($data['tasks'] as $task)
                <li class="flex justify-between items-center py-2 border-b">
                    <span class="text-gray-800">{{ $task['title'] }}</span>
                    @if ($task['priority'] ?? false)
                        <span class="text-red-600 text-sm font-semibold">Prioritas</span>
                    @endif
                    @if (isset($task['deadline']))
                        <span class="text-gray-500 text-sm">{{ $task['deadline'] }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            <a href="#" class="text-indigo-600 font-semibold hover:underline">Lihat Semua Tugas</a>
            <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 ml-4">Mulai Tugas Prioritas</a>
        </div>
    </div>

    <!-- Leaderboard -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Leaderboard</h2>
        <ol class="list-decimal pl-5">
            @foreach ($data['leaderboard'] as $leader)
                <li>
                    <span class="font-semibold">{{ $leader['name'] }}</span> - 
                    <span class="text-gray-700">{{ $leader['points'] }} poin</span>
                </li>
            @endforeach
        </ol>
        <div class="mt-4">
            <a href="#" class="text-indigo-600 font-semibold hover:underline">Lihat Leaderboard Lengkap</a>
        </div>
    </div>

    <!-- Notifikasi & Reminder -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Notifikasi</h2>
        <ul>
            @foreach ($data['notifications'] as $notification)
                <li class="py-2 text-gray-800">
                    - {{ $notification }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
