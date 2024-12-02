@extends('layouts.userapp')

@section('content')
<div class="container">
    <h1 class="display-4 text-dark mb-4"><strong>Leaderboard ({{ ucfirst($period) }})</strong></h1>

    <!-- Leaderboard Ranking -->
    <div class="card mb-4">
        <div class="card-header m-bg-secondary text-white">
            <h2 class="h4 mb-0">Ranking Pengguna</h2>
        </div>
        <div class="card-body">
            @if (count($leaderboard) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $entry->name }}</td> <!-- Corrected this line -->
                            <td>{{ $entry->points }}</td> <!-- Corrected the points property -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">Belum ada data leaderboard tersedia.</p>
            @endif
        </div>
    </div>

    <!-- User's Badges -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Badges Anda</h2>
        </div>
        <div class="card-body">
            @if ($userBadges->count() > 0)
                <div class="d-flex flex-wrap">
                    @foreach ($userBadges as $badge)
                        <div class="badge-item text-center me-3 mb-3">
                            <img src="{{ asset('storage/' . $badge->image) }}" 
                                 alt="{{ $badge->name }}" 
                                 class="img-thumbnail" 
                                 style="width: 80px; height: 80px;">
                            <p class="small mt-2">{{ $badge->name }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Anda belum memiliki badge.</p>
            @endif
        </div>
    </div>
</div>
@endsection
