@extends('layouts.userapp')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Card Profil -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header m-bg-secondary text-white text-center py-4">
                    <h5 class="mb-0" style="font-size: 1.5rem;">Profil Pengguna</h5>
                </div>
                <div class="card-body text-center">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                        alt="Profile Photo" 
                        class="rounded-circle border border-white mb-3" 
                        style="width: 120px; height: 120px;"
                    >
                    <!-- Informasi Pengguna -->
                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                    <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('profile.show') }}" class="btn m-btn-secondary mb-3 mt-2">View Profil</a>
                </div>
            </div>
        </div>

        <!-- Dashboard -->
        <div class="col-md-8">
            <!-- Informasi Poin Total -->
            <div class="card shadow-sm mb-4">
                <div class="card-header m-bg-secondary text-white py-3">
                    <h5 class="mb-0" style="font-size: 1.5rem;">Poin</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <!-- Bagian Poin -->
                    <div class="text-center px-1">
                        <p class="display-4 m-p-secondary" style="font-size:2rem"><strong>{{ $data['totalPoints'] ?? 'No points available' }}</strong></p>
                    </div>
                    <!-- Tombol Penukaran Voucher -->
                    <div class="text-center px-3">
                        <a href="{{ route('redeem.vouchers') }}" class="btn btn-warning m-btn-primary">Voucher Shop</a>
                    </div>
                </div>
            </div>

            <!-- Informasi Tugas Selesai -->

            <!-- Leaderboard -->
            <div class="card shadow-sm">
                <div class="card-header m-bg-secondary text-white mb-2 p-3">
                    <h5 class="mb-0" style="font-size: 1.5rem;">LeaderBoard</h5>
                </div>
                <div class="card-body">
                    <ol class="pl-3">
                        @if ($leaderboard->isNotEmpty())
                            @foreach ($leaderboard as $entry)
                            <li>
                                <strong>{{ $entry->name }}</strong> - 
                                <span class="text-muted">{{ $entry->total_points }} poin</span>
                            </li>
                            @endforeach
                        @else
                            <p class="text-muted">No leaderboard data available.</p>
                        @endif
                    </ol>
                    <div class="mt-2">
                        <a href="{{ route('user.leaderboard') }}" class="btn btn-link text-primary text-decoration-none">Lihat Leaderboard Lengkap</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tugas Harian & Baru -->
        <div class="card shadow-sm mt-4 mb-4">
            <div class="card-header m-bg-secondary text-white mb-2 p-3">
                <h5 class="mb-0" style="font-size: 1.5rem;">Tugas Harian & Baru</h5>
            </div>
            <div class="card-body">
                <!-- Tabel Responsif -->
                <div>
                    <table class="table table-hover">
                        <thead>
                            <tr class="m-bg-primary text-white text-center py-4">
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
                <div class="mt-4 d-flex justify-content-end">
                    <a href="/task" class="btn m-btn-secondary text-decoration-none">Lihat Semua Tugas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
