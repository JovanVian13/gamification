@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Leaderboard</h1>

    <!-- Leaderboard Ranking -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Ranking Pengguna</h2>
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="px-4 py-2">Rank</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['leaderboard'] as $index => $leader)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : '' }}">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $leader['name'] }}</td>
                    <td class="px-4 py-2 text-indigo-600 font-semibold">{{ $leader['points'] }} poin</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Badge & Pencapaian -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Badge & Pencapaian</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($data['badges'] as $badge)
            <div class="bg-gray-100 p-4 rounded-lg shadow flex flex-col items-center text-center">
                <img src="{{ $badge['image'] }}" alt="{{ $badge['title'] }}" class="w-20 h-20 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ $badge['title'] }}</h3>
                <p class="text-sm text-gray-600">{{ $badge['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Statistik dan Target -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Statistik dan Target</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Statistik -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Statistik Anda</h3>
                <ul class="list-disc pl-5 text-gray-700">
                    <li>Total Poin: <span class="font-bold text-indigo-600">{{ $data['stats']['totalPoints'] }}</span></li>
                    <li>Jumlah Tugas Selesai: <span class="font-bold">{{ $data['stats']['tasksCompleted'] }}</span></li>
                    <li>Badge yang Didapat: <span class="font-bold">{{ count($data['badges']) }}</span></li>
                </ul>
            </div>

            <!-- Target -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Target Pencapaian</h3>
                <ul class="list-disc pl-5 text-gray-700">
                    @foreach ($data['targets'] as $target)
                    <li>{{ $target['description'] }} 
                        <span class="font-bold text-indigo-600">
                            ({{ $target['progress'] }}%)
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
