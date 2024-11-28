@extends('layouts.userapp')

@section('content')
<div class="container">
    <h1 class="display-4 text-dark mb-4"><strong>Leaderboard</strong></h1>

    <!-- Leaderboard Ranking -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Ranking Pengguna</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['leaderboard'] as $index => $leader)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $leader['name'] }}</td>
                        <td class="text-primary font-weight-bold">{{ $leader['points'] }} poin</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Badge & Pencapaian -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Badge & Pencapaian</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($data['badges'] as $badge)
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <img src="{{ $badge['image'] }}" alt="{{ $badge['title'] }}" class="card-img-top p-4" style="height: 100px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $badge['title'] }}</h5>
                            <p class="card-text">{{ $badge['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Statistik dan Target -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Statistik dan Target</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Statistik -->
                <div class="col-md-6 mb-3">
                    <h5 class="text-dark">Statistik Anda</h5>
                    <ul class="list-unstyled">
                        <li>Total Poin: <strong class="text-primary">{{ $data['stats']['totalPoints'] }}</strong></li>
                        <li>Jumlah Tugas Selesai: <strong>{{ $data['stats']['tasksCompleted'] }}</strong></li>
                        <li>Badge yang Didapat: <strong>{{ count($data['badges']) }}</strong></li>
                    </ul>
                </div>

                <!-- Target -->
                <div class="col-md-6 mb-3">
                    <h5 class="text-dark">Target Pencapaian</h5>
                    <ul class="list-unstyled">
                        @foreach ($data['targets'] as $target)
                        <li>{{ $target['description'] }} 
                            <strong class="text-primary">({{ $target['progress'] }}%)</strong>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
