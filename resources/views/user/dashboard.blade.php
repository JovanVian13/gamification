@extends('layouts.userapp')

@section('content')
<div class="container mt-4">
    <!-- Grid Layout -->
    <div class="row">
        <!-- Card Profil (Samping Kiri) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header m-bg-primary text-white text-center py-4">
                    <h5 class="mb-0">Profil Pengguna</h5>
                </div>
                <div class="card-body text-center">
                    <!-- Foto Profil -->
                    <img 
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrI__BaxsSuU7xTbKjDif1LRRZu4TFo6Od3A&s" 
                        alt="Profile Photo" 
                        class="rounded-circle border border-white mb-3" 
                        style="width: 120px; height: 120px;">
                    
                    <!-- Informasi Pengguna -->
                    <h5 class="card-title">Name</h5>
                    <p class="card-text text-muted">name@example.com</p>
                </div>
                <!-- Tombol Aksi -->
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('profile.show') }}" class="btn btn-primary m-btn-secondary mb-2 mt-2">View Profil</a>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="col-md-8">
            <!-- Informasi Poin Total -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Poin Anda</h5>
                    <p class="display-4 text-primary"><strong>{{ $data['totalPoints'] ?? 'No points available' }}</strong></p>
                </div>
            </div>

            <!-- Leaderboard -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Leaderboard</h5>
                    <ol class="pl-3">
                        @foreach ($data['leaderboard'] as $leader)
                        <li>
                            <strong>{{ $leader['name'] }}</strong> - 
                            <span class="text-muted">{{ $leader['points'] }} poin</span>
                        </li>
                        @endforeach
                    </ol>
                    <div class="mt-3">
                        <a href="/leaderboard" class="btn btn-link text-primary">Lihat Leaderboard Lengkap</a>
                    </div>
                </div>
            </div>

            <!-- Tombol Penukaran Voucher -->
            <div class="card shadow-sm mt-4 mb-4">
                <div class="card-body text-center">
                    <a href="{{ route('voucher.redeem') }}" class="btn btn-warning btn-lg">Tukar Voucher</a>
                </div>
            </div>
        </div>

    <!-- Tugas Harian & Baru (Lebar Penuh) -->
    <div class="card shadow-sm mt-4 mb-4">
        <div class="card-body">
            <h5 class="card-title">Tugas Harian & Baru</h5>

            <!-- Header Kolom -->
            <div class="d-flex border-bottom pb-2 mb-3">
                <div class="w-25"><strong>Tugas</strong></div>
                <div class="w-25 text-center"><strong>Prioritas</strong></div>
                <div class="w-25 text-center"><strong>Deadline</strong></div>
                <div class="w-25 text-center"><strong>Status</strong></div>
            </div>

            <!-- Daftar Tugas -->
            <ul class="list-unstyled">
                @foreach ($data['tasks'] as $task)
                <li class="d-flex align-items-center py-2 border-bottom">
                    <!-- Nama Tugas -->
                    <div class="w-25">{{ $task['title'] }}</div>

                    <!-- Prioritas -->
                    <div class="w-25 text-center">
                        @if ($task['priority'] ?? false)
                            <span class="text-danger font-weight-bold">Prioritas</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>

                    <!-- Deadline -->
                    <div class="w-25 text-center">
                        @if (isset($task['deadline']))
                            <span class="text-muted">{{ $task['deadline'] }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="w-25 text-center text-muted">Done</div>
                </li>
                @endforeach
            </ul>

            <!-- Tombol Aksi -->
            <div class="mt-4 d-flex justify-content-between">
                <a href="/tasks" class="btn btn-link text-primary">Lihat Semua Tugas</a>
                <a href="#" class="btn btn-primary m-btn-secondary">Mulai Tugas Prioritas</a>
            </div>
        </div>
    </div>
</div>
@endsection
