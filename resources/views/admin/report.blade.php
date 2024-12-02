@extends('layouts.admin')

@section('title', 'Reports and Analytics')

@section('content')
<div class="container">
    <h1>Reports and Analytics</h1>

    <div class="row">
        <!-- Voucher -->
        <div class="col-md-4">
            <h5>Voucher</h5>
            <p>Jumlah voucher yang ditukar: {{ $voucherStats->sum('redemptions_count') }}</p>
        </div>
    </div>

    <!-- Grafik Pendaftaran -->
    <h5 class="mt-4">Grafik Tren Pendaftaran</h5>
    <canvas id="userRegistrationChart"></canvas>

    <!-- Grafik Statistik Tugas -->
    <h5 class="mt-4">Statistik Tugas</h5>
    <canvas id="taskStatsChart"></canvas>

    <!-- Tombol Ekspor -->
    <div class="mt-4">
        <a href="{{ route('admin.reportexport.csv') }}" class="btn btn-primary">Export CSV</a>
        <a href="{{ route('admin.reportexport.excel') }}" class="btn btn-success">Export Excel</a>
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
        labels: {!! json_encode($taskStats->pluck('title')) !!},
        datasets: [{
            label: 'Jumlah Penyelesaian',
            data: {!! json_encode($taskStats->pluck('completions_count')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }]
    };

    // Render grafik
    const userRegistrationChart = new Chart(document.getElementById('userRegistrationChart'), {
        type: 'line',
        data: userRegistrationData,
    });

    const taskStatsChart = new Chart(document.getElementById('taskStatsChart'), {
        type: 'bar',
        data: taskStatsData,
    });
</script>
@endpush
