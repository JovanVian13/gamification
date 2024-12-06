@extends('layouts.userapp')

@section('content')

<div class="container">
    <!-- Leaderboard Ranking -->
    <div class="card mb-4 shadow">
        <div class="card-header m-bg-primary text-white text-center py-3">
            <h2 class="h4 mb-0">Leaderboard</h2>
        </div>
        <div class="card-body">
            @if (count($leaderboard) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $entry->name }}</td>
                            <td>{{ $entry->points }}</td>
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
    <div class="card mb-4 shadow">
        <div class="card-header m-bg-secondary text-white text-center py-3">
            <h2 class="h4 mb-0">Ranking Anda</h2>
        </div>
        <div class="card-body text-center">
            <!-- Rank in a Circle -->
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center mx-auto m-bg-primary" 
                style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                {{ $rank }}
            </div>
            <!-- Points Below the Circle -->
            <div class="mt-3" style="font-size: 1.5rem;">
                <strong>{{ $leaderboard->where('id', Auth::id())->first()->points ?? 0 }}</strong>
                <span>Points</span>
            </div>
        </div>
    </div>
    @else
    <div class="card mb-4 shadow">
        <div class="card-header m-bg-secondary text-white text-center py-3">
            <h2 class="h4 mb-0">Ranking Anda</h2>
        </div>
        <div class="card-body text-center">
            <!-- Rank in a Circle -->
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center mx-auto m-bg-primary" 
                style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                N/A
            </div>
            <!-- Points Below the Circle -->
            <div class="mt-3" style="font-size: 1.5rem;">
                <strong>{{ $leaderboard->where('id', Auth::id())->first()->points ?? 0 }}</strong>
                <span>Points</span>
            </div>
        </div>
    </div>
    @endif

    <!-- User's Badges -->
    <div class="card mt-4 mb-4 shadow">
        <div class="card-header m-bg-secondary text-white text-center py-3">
            <h2 class="h4 mb-0">Badges Anda</h2>
        </div>
        <div class="card-body">
            @if ($userBadges->count() > 0)
                <div class="d-flex flex-wrap">
                    @foreach ($userBadges as $badge)
                        <div class="badge-item text-center me-3 mb-3 p-4" style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $badge->criteria }}<br>Earned: {{ $badge->pivot->earned_at ? \Carbon\Carbon::parse($badge->pivot->earned_at)->format('d F Y') : 'N/A' }}">
                            <img src="{{ asset('storage/' . $badge->image) }}" 
                                 alt="{{ $badge->name }}" 
                                 class="rounded-circle shadow" 
                                 style="width: 100px; height: 100px;">
                            <p style="font-size: 1.25rem;font-weight: bold mt-2">{{ $badge->name }}</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true
            });
        });
    });
</script>
@endpush
