@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="display-4 text-dark mb-4"><strong>Leaderboard ({{ ucfirst($period) }})</strong></h1>

    <!-- Leaderboard Ranking -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Ranking Pengguna</h2>
        </div>
        <div class="card-body">
            @if (count($leaderboard) > 0)
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $leader)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $leader->name }}</td>
                        <td class="text-primary font-weight-bold">{{ $leader->points }} poin</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">Belum ada data leaderboard tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endsection
