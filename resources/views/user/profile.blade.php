@extends('layouts.userapp')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!-- User Information Section -->
                <div class="card shadow-sm mb-4">
                    <div class="mb-3">
                        <div class="card-header m-bg-primary text-white text-center py-3">
                            <h5 class="mb-0" style="font-size: 1.5rem;">Informasi Pribadi</h5>
                        </div>
                        <div class="card p-3 shadow-sm mt-4 ms-4 me-4" style="border-radius: 1px;">
                            <div class="d-flex align-items-center">
                                <!-- Foto Profil -->
                                <div class="me-3">
                                    <img 
                                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                                        alt="Profile Photo" 
                                        class="rounded-circle border border-white" 
                                        style="width: 90px; height: 100px;"
                                    >
                                </div>
                                <!-- Informasi Pribadi -->
                                <div>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                                        <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                                        <li><strong>Umur:</strong> {{ Auth::user()->age }}</li>
                                        <li><strong>Lokasi:</strong> {{ Auth::user()->location }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                        <a href="{{ route('profile.edit') }}" class="btn m-btn-secondary btn-block mt-4">Ubah Profil</a>
                        </div>
                    </div>
                    
                </div>
            </div>
            

            <div class="col-lg-6">
                <!-- Points and Voucher History Section -->
                <div class="card shadow-sm mb-4">
                    <!-- Header Card Utama -->
                    <div class="card-header m-bg-primary text-white text-center py-3">
                        <h5 class="mb-0" style="font-size: 1.5rem;">Riwayat Poin dan Penukaran Voucher</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Card Kiri -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mt-2 ms-2 mb-3" style="border-radius: 10px;">
                                    <!-- Header Card Kiri -->
                                    <div class="card-header m-bg-secondary text-white text-center py-3">
                                        <h6 class="mb-0">Poin Terpakai</h6>
                                    </div>
                                    <!-- Body Card Kiri -->
                                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                        <span class="fw-bold text-orange" style="font-size: 2.5rem; color: orange;">
                                            {{ $totalPointCount }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Kanan -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mt-2 me-2 mb-3" style="border-radius: 10px;">
                                    <!-- Header Card Kanan -->
                                    <div class="card-header m-bg-secondary text-white text-center py-3">
                                        <h6 class="mb-0">Voucher Terklaim</h6>
                                    </div>
                                    <!-- Body Card Kanan -->
                                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                        <span class="fw-bold text-orange" style="font-size: 2.5rem; color: orange;">
                                            {{ $totalRedemptionCount }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- Task Statistics Section -->
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header m-bg-primary text-white text-center py-3">
                        <h5 class="mb-0" style="font-size: 1.5rem;">Statistik Tugas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <!-- Video -->
                        <div class="col-md-3">
                            <div class="card shadow-sm mt-2 ms-2 mb-3" style="border-radius: 10px;">
                                <div class="card-header m-bg-secondary text-white text-center py-3">
                                    <h6 class="mb-0">Video</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                    <canvas id="videoChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Like -->
                        <div class="col-md-3">
                            <div class="card shadow-sm mt-2 me-2 mb-3" style="border-radius: 10px;">
                                <div class="card-header m-bg-secondary text-white text-center py-3">
                                    <h6 class="mb-0">Like</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                    <canvas id="likeChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="col-md-3">
                            <div class="card shadow-sm mt-2 me-2 mb-3" style="border-radius: 10px;">
                                <div class="card-header m-bg-secondary text-white text-center py-3">
                                    <h6 class="mb-0">Comment</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                    <canvas id="commentChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Share -->
                        <div class="col-md-3">
                            <div class="card shadow-sm mt-2 me-2 mb-3" style="border-radius: 10px;">
                                <div class="card-header m-bg-secondary text-white text-center py-3">
                                    <h6 class="mb-0">Share</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 125px;">
                                    <canvas id="shareChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Legend Section -->
                        <div class="mt-4 text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="me-3 d-flex align-items-center">
                                    <span class="legend-box" style="background-color: #fbb041;"></span> <span>Sudah Dikerjakan</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="legend-box" style="background-color: #232E66;"></span> <span>Belum Dikerjakan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statistics = @json($statistics);
    
        // Membuat grafik untuk setiap tipe tugas
        Object.keys(statistics).forEach(type => {
            const ctx = document.getElementById(`${type}Chart`).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Sudah Dikerjakan', 'Belum Dikerjakan'],
                    datasets: [{
                        data: [statistics[type].completed, statistics[type].incomplete],
                        backgroundColor: ['#fbb041', '#232E66'],
                        hoverOffset: 4,
                        borderWidth: 0 // Hilangkan border
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '45%'
                }
            });
        });
    </script>
    

@endsection
