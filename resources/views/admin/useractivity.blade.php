@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <h1>Aktivitas Pengguna</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Pengguna</th>
                <th>Jenis Aktivitas</th>
                <th>Detail</th>
                <th>Poin</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->user->name }}</td>
                    <td>{{ $activity->activity_type }}</td>
                    <td>{{ $activity->activity_detail }}</td>
                    <td>{{ $activity->points_earned ?? '-' }}</td>
                    <td>{{ $activity->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $activities->links() }}

    <!-- Area Grafik -->
    <div class="row my-5">
        <div class="col-md-6">
            <h3>Grafik Task Completed</h3>
            <canvas id="taskChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Grafik Point Conversion</h3>
            <canvas id="conversionChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch data from the endpoint
        fetch("{{ route('admin.activitychart') }}")
            .then(response => response.json())
            .then(data => {
                // Initialize Task Chart
                const taskCtx = document.getElementById('taskChart').getContext('2d');
                new Chart(taskCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data.tasks),
                        datasets: [{
                            label: 'Jumlah Penyelesaian',
                            data: Object.values(data.tasks),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                // Initialize Conversion Chart
                const conversionCtx = document.getElementById('conversionChart').getContext('2d');
                new Chart(conversionCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(data.conversions),
                        datasets: [{
                            label: 'Konversi Poin',
                            data: Object.values(data.conversions),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            });
    });
</script>
@endsection
