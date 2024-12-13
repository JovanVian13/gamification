@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="display-6 text-dark mb-4"><strong>Leaderboard ({{ ucfirst($period) }})</strong></h1>

    <!-- Leaderboard Ranking -->
    <div class="card mb-4">
        <div class="card-header bg-gray text-white">
            <h2 class="h4 mb-0 text-dark">Ranking Pengguna</h2>
        </div>
        <div class="card-body">
            @if (count($leaderboard) > 0)
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center">Rank</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Poin</th>
                        <th scope="col" class="text-center">Total Tasks</th>
                        <th scope="col" class="text-center">Watch</th>
                        <th scope="col" class="text-center">Like</th>
                        <th scope="col" class="text-center">Share</th>
                        <th scope="col" class="text-center">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $leader)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $leader->name }}</td>
                        <td class="text-primary font-weight-bold text-center">{{ $leader->points }} poin</td>
                        <td class="text-center">{{ $leader->total_tasks }}</td>
                        <td class="text-center">{{ $leader->watch_frequency }}</td>
                        <td class="text-center">{{ $leader->like_frequency }}</td>
                        <td class="text-center">{{ $leader->share_frequency }}</td>
                        <td class="text-center">{{ $leader->comment_frequency }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $leaderboard->links() }}
            @else
            <p class="text-muted">Belum ada data leaderboard tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endsection
