@extends('layouts.userapp')

@section('content')

<div class="container">
    <!-- Leaderboard Ranking -->
    <div class="card mb-4 shadow border-2">
        <div class="card-header text-white text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Leaderboard</h2>
        </div>
        <div class="card-body">
            @if (count($leaderboard) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Points</th>
                        <th>Total Tasks</th>
                        <th>Watch</th>
                        <th>Like</th>
                        <th>Share</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $entry->name }}</td>
                            <td>{{ $entry->points }}</td>
                            <td>{{ $entry->total_tasks }}</td>
                            <td>{{ $entry->watch_frequency }}</td>
                            <td>{{ $entry->like_frequency }}</td>
                            <td>{{ $entry->share_frequency }}</td>
                            <td>{{ $entry->comment_frequency }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">Belum ada data leaderboard tersedia.</p>
            @endif
        </div>
    </div>

    <!-- User's Ranking -->
    @if ($rank !== null)
    <div class="card mb-4 shadow border-2">
        <div class="card-header text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Ranking Anda</h2>
        </div>
        <div class="card-body text-center">
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center mx-auto m-bg-primary" 
                style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                {{ $rank }}
            </div>
            <div class="mt-3" style="font-size: 1.5rem;">
                <strong>{{ $leaderboard->where('id', Auth::id())->first()->points ?? 0 }}</strong>
                <span>Points</span>
            </div>
        </div>
    </div>
    @else
    <div class="card mb-4 shadow border-2">
        <div class="card-header text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Ranking Anda</h2>
        </div>
        <div class="card-body text-center">
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center mx-auto m-bg-primary" 
                style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                N/A
            </div>
            <div class="mt-3" style="font-size: 1.5rem;">
                <strong>{{ $leaderboard->where('id', Auth::id())->first()->points ?? 0 }}</strong>
                <span>Points</span>
            </div>
        </div>
    </div>
    @endif

    <!-- User's Badges -->
    <div class="card mt-4 mb-4 shadow border-2">
        <div class="card-header text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Badges Anda</h2>
        </div>
        <div class="card-body">
            @if ($userBadges->count() > 0)
                <div class="row g-3">
                    @foreach ($userBadges as $badge)
                        <div class="col-6 col-md-4 col-lg-3 text-center" data-bs-toggle="tooltip" 
                            data-bs-html="true" 
                            title="<strong>{{ $badge->criteria }}</strong><br>Earned: {{ $badge->pivot->earned_at ? \Carbon\Carbon::parse($badge->pivot->earned_at)->format('d F Y') : 'N/A' }}">
                            <div class="badge-item p-2">
                                <img src="{{ asset('storage/' . $badge->image) }}" 
                                    alt="{{ $badge->name }}" 
                                    class="rounded-circle shadow" 
                                    style="width: 100px; height: 100px;">
                                <p class="mt-2 mb-0 fw-bold">{{ $badge->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center">Anda belum memiliki badge.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true
            });
        });
    });
</script>
@endpush
