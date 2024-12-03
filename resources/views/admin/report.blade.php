@extends('layouts.admin')

@section('title', 'Reports and Analytics')

@section('content')
<div class="container">
    <h1 class="mb-4">Reports and Analytics</h1>

    <!-- Statistik Pengguna -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pengguna Aktif</h5>
                    <p>Harian: <strong>{{ $dailyUsers }}</strong></p>
                    <p>Mingguan: <strong>{{ $weeklyUsers }}</strong></p>
                    <p>Bulanan: <strong>{{ $monthlyUsers }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Statistik Voucher -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Voucher</h5>
                    <p>Jumlah voucher yang ditukar: <strong>{{ $voucherStats->sum('total_redemptions') }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendaftaran -->
    <div class="mb-4">
        <h5>Grafik Tren Pendaftaran</h5>
        @if ($newUsers->count())
        <canvas id="userRegistrationChart"></canvas>
        @else
        <p class="text-muted">Tidak ada data pendaftaran tersedia.</p>
        @endif
    </div>

    <!-- Grafik Statistik Tugas -->
    <div class="mb-4">
        <h5>Statistik Tugas</h5>
        @if ($taskStats->count())
        <canvas id="taskStatsChart"></canvas>
        @else
        <p class="text-muted">Tidak ada data tugas tersedia.</p>
        @endif
    </div>

    <!-- Tombol Ekspor -->
    <div class="mt-4">
        <a href="{{ route('admin.exportcsv') }}" class="btn m-btn-primary">Export CSV</a>
        <a href="{{ route('admin.exportexcel') }}" class="btn btn-success">Export Excel</a>
    </div>
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
        });
    }

    if (document.getElementById('taskStatsChart')) {
        new Chart(document.getElementById('taskStatsChart'), {
            type: 'bar',
            data: taskStatsData,
        });
    }
</script>
@endpush
