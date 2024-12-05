@extends('layouts.userapp')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- User Information Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="m-bg-primary text-white p-3 text-center mb-3">Informasi Pribadi</h4>
                        <ul class="list-unstyled">
                            <!-- Foto Profil -->
                            <li class="mb-3 text-center">
                            <img 
                                src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                                alt="Profile Photo" 
                                class="rounded-circle border border-white mb-3" 
                                style="width: 120px; height: 120px;"
                            >
                            </li>
                            <!-- Nama Pengguna -->
                            <li><strong>Name: {{ Auth::user()->name }}</strong></li>
                            <!-- Email Pengguna -->
                            <li><strong>Email: {{ Auth::user()->email }}</strong></li>
                            <!-- Umur Pengguna -->
                            <li><strong>Age: {{ Auth::user()->age }}</strong></li>
                            <!-- Lokasi Pengguna -->
                            <li><strong>Location: {{ Auth::user()->location }}</strong></li>
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
                        <a href="{{ route('usertask') }}" class="btn m-btn-secondary mb-3 mt-3">Lihat Semua Tugas</a>
                    </div>
                </div>

                <!-- Points and Voucher History Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="m-bg-primary text-white p-3">Histori Poin dan Penukaran Voucher</h4>
                        <ul class="list-unstyled">
                            <li><strong>Total Poin:</strong> {{ $totalPoints }}</li>
                            <li><strong>Total Penukaran Voucher:</strong> {{ $totalRedemptionCount }}</li>
                        </ul>
                        <a href="{{ route('redeem.vouchers') }}" class="btn m-btn-secondary mb-3 mt-3">Tukar Voucher</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
