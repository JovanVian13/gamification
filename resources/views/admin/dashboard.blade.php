@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex">
    <!-- Main Content -->
    <main class="flex-grow-1 p-4">
        <h1 class="mb-4">Welcome to Admin Dashboard</h1>
        <h2 class="mb-4">Reports and Analytics</h2>

        <!-- Statistik Pengguna -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pengguna Aktif</h5>
                        <p>Harian: <strong>{{ $dailyUsers }}</strong></p>
                        <p>Mingguan: <strong>{{ $weeklyUsers }}</strong></p>
                        <p>Bulanan: <strong>{{ $monthlyUsers }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Voucher</h5>
                        <p>Jumlah voucher yang ditukar: <strong>{{ $voucherStats->sum('total_redemptions') }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pendaftaran -->
        <div class="row mb-4">
            <div class="col-12">
                <h5>Grafik Tren Pendaftaran</h5>
                @if ($newUsers->count())
                <div class="chart-container" style="position: relative; height: 50vh;">
                    <canvas id="userRegistrationChart"></canvas>
                </div>
                @else
                <p class="text-muted">Tidak ada data pendaftaran tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Grafik Statistik Tugas -->
        <div class="row mb-4">
            <div class="col-12">
                <h5>Statistik Tugas</h5>
                @if ($taskStats->count())
                <div class="chart-container" style="position: relative; height: 50vh;">
                    <canvas id="taskStatsChart"></canvas>
                </div>
                @else
                <p class="text-muted">Tidak ada data tugas tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Tombol Ekspor -->
        <div class="mt-4 d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('exportcsv') }}" class="btn btn-primary w-100 w-md-auto">Export CSV</a>
            <a href="{{ route('exportexcel') }}" class="btn btn-success w-100 w-md-auto">Export Excel</a>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik pendaftaran
    const userRegistrationData = {
        labels: {!! json_encode($newUsers->pluck('date')) !!},
        datasets: [{
            label: 'Pendaftaran Baru',
            data: {!! json_encode($newUsers->pluck('count')) !!},
            borderColor: 'blue',
            borderWidth: 2,
        }]
    };

    // Data untuk grafik statistik tugas
    const taskStatsData = {
        labels: {!! json_encode($taskStats->pluck('task.title')) !!},
        datasets: [{
            label: 'Jumlah Penyelesaian',
            data: {!! json_encode($taskStats->pluck('total_completions')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }]
    };

    // Render grafik
    if (document.getElementById('userRegistrationChart')) {
        new Chart(document.getElementById('userRegistrationChart'), {
            type: 'line',
            data: userRegistrationData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    }

    if (document.getElementById('taskStatsChart')) {
        new Chart(document.getElementById('taskStatsChart'), {
            type: 'bar',
            data: taskStatsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    }
</script>
@endpush
