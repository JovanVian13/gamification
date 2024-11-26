@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Profil (Samping Kiri) -->
        <div class="col-span-1">
            <div class="max-w-sm bg-white shadow rounded-lg overflow-hidden flex flex-col justify-between">
                <div class="flex items-center px-6 py-3 bg-indigo-600 h-20">
                    <h1 class="text-white text-lg font-semibold">Profil Pengguna</h1>
                </div>
                <div class="px-6 py-6">
                    <!-- Foto Profil -->
                    <div class="flex justify-center">
                        <img 
                            class="w-28 h-28 rounded-full border-4 border-white -mt-14" 
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrI__BaxsSuU7xTbKjDif1LRRZu4TFo6Od3A&s" 
                            alt="Profile Photo">
                    </div>
                        
                    <!-- Informasi Pengguna -->
                    <div class="text-center mt-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Name</h2>
                        <p class="text-gray-600">name@example.com</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="px-6 py-4 mt-auto mb-4">
                    <div class="flex justify-center">
                        <a href="#" 
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                            View Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="col-span-1 md:col-span-2">
            <!-- Informasi Poin Total -->
            <div class="bg-white shadow rounded-lg p-6 mb-4">
                <h2 class="text-2xl font-semibold mb-4">Poin Anda</h2>
                <p class="text-4xl font-bold text-indigo-600">{{ $data['totalPoints'] }}</p>
            </div>

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
                    <a href="/leaderboard" class="text-indigo-600 font-semibold hover:underline">Lihat Leaderboard Lengkap</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas Harian & Baru (Lebar Penuh) -->
    <div class="bg-white shadow rounded-lg p-6 mb-6 mt-6 w-full">
        <h2 class="text-2xl font-semibold mb-4">Tugas Harian & Baru</h2>

        <!-- Header Kolom -->
        <div class="flex justify-between items-center border-b-2 pb-2">
            <span class="text-gray-800 font-semibold w-1/4">Tugas</span>
            <span class="text-gray-800 font-semibold w-1/4 text-center">Prioritas</span>
            <span class="text-gray-800 font-semibold w-1/4 text-center">Deadline</span>
            <span class="text-gray-800 font-semibold w-1/4 text-center">Status</span>
        </div>

        <!-- Daftar Tugas -->
        <ul>
            @foreach ($data['tasks'] as $task)
                <li class="flex justify-between items-center py-2 border-b">
                    <!-- Nama Tugas -->
                    <span class="text-gray-800 w-1/4">{{ $task['title'] }}</span>
                    
                    <!-- Prioritas -->
                    <span class="text-sm font-semibold w-1/4 text-center">
                        @if ($task['priority'] ?? false)
                            <span class="text-red-600">Prioritas</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </span>
                    
                    <!-- Deadline -->
                    <span class="text-gray-500 text-sm w-1/4 text-center">
                        @if (isset($task['deadline']))
                            {{ $task['deadline'] }}
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </span>

                    <span class="text-gray-500 text-sm w-1/4 text-center">
                        Done
                    </span>
                </li>
            @endforeach
        </ul>

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <a href="#" class="text-indigo-600 font-semibold hover:underline">Lihat Semua Tugas</a>
            <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 ml-4">Mulai Tugas Prioritas</a>
        </div>
    </div>
</div>
@endsection
