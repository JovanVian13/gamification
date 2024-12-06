@extends('layouts.userapp')

@section('content')
<div class="container">
    <div class="row">
        <!-- Card Profil -->
        <div class="col-md-5 mb-4">
            <div class="card shadow border-2">
                <div class="card-header text-white text-center py-3">
                    <h5 class="mb-0 m-p-secondary" style="font-size: 1.5rem;">Profile</h5>
                </div>
                <div class="card-body text-center">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                        alt="Profile Photo" 
                        class="rounded-circle shadow mb-4 mt-3" 
                        style="width: 120px; height: 120px;"
                    >
                    <!-- Informasi Pengguna -->
                    <h3 class="card-title">{{ Auth::user()->name }}</h3>
                    <p class="card-text text-muted" style="font-size: 1.25rem">{{ Auth::user()->email }}</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('profile.show') }}" class="btn m-btn-secondary mb-5 mt-3">View Profil</a>
                </div>
            </div>
        </div>

        <!-- Dashboard -->
        <div class="col-md-7">
            <!-- Informasi Poin Total -->
            <div class="card shadow mb-4 border-2">
                <div class="card-header text-white py-3">
                    <h5 class="mb-0 text-center m-p-secondary" style="font-size: 1.5rem;">Poin</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <!-- Bagian Poin -->
                    <div class="text-center px-4 shadow-sm border rounded">
                        <p class="font-weight-bold m-text-primary mb-1">Total Poin Saya:<br><strong>{{ $data['totalPoints'] ?? 'No points available' }}</strong></p>
                    </div>
                    <!-- Bagian Ranking -->
                    <div class="text-center shadow-sm px-4 border rounded">
                        <p class="font-weight-bold m-text-primary mb-1">
                            Rank Saya: <br>
                            <span class="m-bg-primary px-2 rounded font-weight-bold text-white">{{ $data['rank'] ?? 'N/A' }}</span>
                        </p>
                    </div>
                    <!-- Tombol Penukaran Voucher -->
                    <div class="text-center px-4 py-3 shadow-sm border rounded">
                        <a href="{{ route('redeem.vouchers') }}" class="text-black text-decoration-none"><i class="bi bi-basket3-fill"></i> Tukar Voucher ></a>
                    </div>
                </div>
            </div>

            <!-- Leaderboard -->
            <div class="card shadow border-2">
                <div class="card-header text-white mb-2 p-3">
                    <h5 class="mb-0 m-p-secondary text-center" style="font-size: 1.5rem;">LeaderBoard</h5>
                </div>
                <div class="card-body row">
                    <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                        <!-- Gambar Piala -->
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            @if(isset($leaderboard[1]))
                            <img
                                src="{{ $leaderboard[1]->profile_picture ? asset('storage/' . $leaderboard[1]->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @else
                            <img
                                src="{{ asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @endif
                            <img
                                src="{{ asset('assets/img/trophy2.png') }}" 
                                alt="Trophy" 
                                style="width: 90px; height: 90px;"
                            >
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center">
                            @if(isset($leaderboard[0]))
                            <img
                                src="{{ $leaderboard[0]->profile_picture ? asset('storage/' . $leaderboard[0]->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @else
                            <img
                                src="{{ asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @endif
                            <img
                            src="{{ asset('assets/img/trophy1.png') }}" 
                                alt="Trophy" 
                                style="width: 110px; height: 110px;"
                            >
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center">
                            @if(isset($leaderboard[2]))
                            <img
                                src="{{ $leaderboard[2]->profile_picture ? asset('storage/' . $leaderboard[2]->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @else
                            <img
                                src="{{ asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="rounded-circle shadow" 
                                style="width: 40px; height: 40px;"
                            >
                            @endif
                            <img 
                                src="{{ asset('assets/img/trophy3.png') }}" 
                                alt="Trophy" 
                                style="width: 100px; height: 100px;"
                            >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <ol class="mb-0">
                            @if ($leaderboard->isNotEmpty())
                                @foreach ($leaderboard as $index => $entry)
                                <li class="d-flex justify-content-between align-items-center border border-secondary rounded p-2 mb-1" style="font-size: 0.75rem; list-style: none;">
                                    <!-- Informasi Leaderboard -->
                                    <div class="d-flex align-items-center">
                                        <span class="m-bg-primary px-2 rounded font-weight-bold text-white me-2">{{ $index + 1 }}</span>
                                        <strong class="me-4">{{ $entry->name }}</strong>
                                    </div>
                                    <span class="text-muted ms-4">{{ $entry->total_points }} poin</span>
                                </li>
                                @endforeach
                            @else
                                <p class="text-muted">No leaderboard data available.</p>
                            @endif
                        </ol>
                        <div class="text-end m-0">
                            <a href="{{ route('user.leaderboard') }}" style="font-size: 0.75rem;" class="btn text-primary text-decoration-none">Lihat Selengkapnya >></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas Harian & Baru -->
    <div class="card shadow mt-4 mb-4 rounded border-2">
        <div class="card-header text-white text-center mb-2 p-3">
            <h5 class="mb-0 m-p-secondary" style="font-size: 1.5rem;">Tugas Harian</h5>
        </div>
        <div class="card-body">
            <!-- Tabel Responsif -->
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr class="font-weight-bold text-center py-4">
                            <th scope="col">No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Points</th>
                            <th scope="col">Video Link</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($data['tasks'] as $index => $task)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $task->task->title ?? 'Tugas Tidak Ditemukan' }}</td>
                            <td>
                                <span class="{{ $task->status == 'completed' ? 'text-success' : 'text-warning' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->task->points ?? '0' }}</td>
                            <td>
                                @if (!empty($task->task->url))
                                <a href="{{ $task->task->url }}" target="_blank" class="btn btn-link text-primary text-decoration-none">
                                    Watch Video
                                </a>
                                @else
                                <span class="text-muted">No Video</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada tugas untuk ditampilkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Tombol Lihat Semua -->
            <div class="mt-4 d-flex">
                <a href="/task" class="btn m-btn-secondary text-decoration-none rounded">Lihat Semua Tugas</a>
            </div>
        </div>
    </div>
</div>
@endsection
