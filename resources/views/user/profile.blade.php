@extends('layouts.userapp')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <!-- User Information Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="m-bg-primary text-white p-3">Informasi Pribadi</h4>
                        <ul class="list-unstyled">
                            <li><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                            <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                            <li><strong>Umur:</strong> {{ Auth::user()->age }}</li>
                            <li><strong>Lokasi:</strong> {{ Auth::user()->location }}</li>
                        </ul>
                        <a href="{{ route('profile.edit') }}" class="btn m-btn-secondary btn-block">Edit Profil</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Task Statistics Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="m-bg-primary text-white p-3">Statistik Tugas</h4>
                        <p><strong>Total Tugas Selesai:</strong> {{ $completedTasksCount }}</p>
                        <p><strong>Tugas yang Sedang Dikerjakan:</strong> {{ $inProgressTasksCount }}</p>
                        <a href="{{ route('tasks') }}" class="btn m-btn-secondary">Lihat Semua Tugas</a>
                    </div>
                </div>

                <!-- Points and Voucher History Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="m-bg-primary text-white p-3">Histori Poin dan Penukaran Voucher</h4>
                        <ul class="list-unstyled">
                            <li><strong>Total Poin:</strong> {{ $totalPoints }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
