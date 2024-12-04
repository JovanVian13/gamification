@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="card-body">
    @if($userTasks->isEmpty())
        <div class="text-center">
            <strong>No tasks available.</strong>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table m-bg-primary">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Points</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userTasks as $userTask)
                        @php
                            $videoId = null;
                            $url = $userTask->task->url;
                            if ($userTask->task->type === 'video') {
                                if (strpos($url, 'youtu.be') !== false) {
                                    $videoId = basename($url);
                                } elseif (strpos($url, 'youtube.com') !== false) {
                                    parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
                                    $videoId = $queryParams['v'] ?? null;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $userTask->task->title }}</td>
                            <td>
                                <span class="badge bg-{{ $userTask->status === 'completed' ? 'success' : 'warning text-dark' }}">
                                    {{ ucfirst($userTask->status) }}
                                </span>
                            </td>
                            <td>{{ $userTask->task->points }}</td>
                            <td>
                                @if ($userTask->task->type === 'video')
                                    @if ($videoId)
                                        <div id="player-{{ $userTask->id }}" class="ratio ratio-16x9"></div>
                                    @else
                                        <span class="text-muted">Invalid Video URL</span>
                                    @endif
                                @elseif ($userTask->task->type === 'like' || $userTask->task->type === 'comment' || $userTask->task->type === 'share')
                                    <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="bi bi-{{ $userTask->task->type === 'like' ? 'hand-thumbs-up' : ($userTask->task->type === 'comment' ? 'chat' : 'share') }}"></i>
                                        {{ ucfirst($userTask->task->type) }} Content
                                    </a>
                                @else
                                    <span class="text-muted">Unknown Task Type</span>
                                @endif
                            </td>
                            <td>
                                @if($userTask->status === 'incomplete')
                                    <form action="{{ route('usertask.complete', $userTask->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Complete
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-check-circle-fill"></i> Completed
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    var players = {}; // Objek untuk menyimpan semua player

    function onYouTubeIframeAPIReady() {
        @foreach ($userTasks as $userTask)
            @php
                $videoId = null;
                $url = $userTask->task->url;
                if ($userTask->task->type === 'video') {
                    if (strpos($url, 'youtu.be') !== false) {
                        $videoId = basename($url);
                    } elseif (strpos($url, 'youtube.com') !== false) {
                        parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
                        $videoId = $queryParams['v'] ?? null;
                    }
                }
            @endphp
            @if ($userTask->task->type === 'video' && isset($videoId))
                players['player-{{ $userTask->id }}'] = new YT.Player('player-{{ $userTask->id }}', {
                    videoId: '{{ $videoId }}',
                    events: {
                        'onStateChange': function(event) {
                            if (event.data === YT.PlayerState.ENDED) {
                                markTaskAsComplete('{{ $userTask->id }}');
                            }
                        }
                    }
                });
            @endif
        @endforeach
    }

    function markTaskAsComplete(taskId) {
        fetch('{{ route("track.interaction") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ task_id: taskId, event_type: 'watched' })
        })
        .then(response => response.json())
        .then(data => alert(data.message || 'Task marked as completed!'))
        .catch(error => alert('Error: ' + error.message));
    }
</script>
@endsection
