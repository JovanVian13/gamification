@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="container mb-5">
    <div class="card shadow border-2">
        <div class="card-header text-white p-3">
            <h1 class="h3 mb-0 text-center m-p-secondary">My Tasks</h1>
        </div>
        <div class="card-body">
            @if($userTasks->isEmpty())
                <div class="text-center">
                    <strong>No tasks available.</strong>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Points</th>
                                <th>Link Tugas</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTasks as $userTask)
                                <tr>
                                    <td>{{ $loop->iteration + ($userTasks->currentPage() - 1) * $userTasks->perPage() }}</td>
                                    <td>{{ $userTask->task->title }}</td>
                                    <td>{{ $userTask->task->points }}</td>
                                    <td>
                                        @if (!empty($userTask->task->url))
                                            @if ($userTask->task->type === 'video')
                                                <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link text-primary text-decoration-none"
                                                    onclick="markTaskAsComplete({{ $userTask->id }})">
                                                    Watch Video
                                                </a>
                                            @elseif ($userTask->task->type === 'like')
                                                <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link text-success text-decoration-none"
                                                    onclick="markTaskAsComplete({{ $userTask->id }})">
                                                    Like Post
                                                </a>
                                            @elseif ($userTask->task->type === 'comment')
                                                <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link text-info text-decoration-none"
                                                    onclick="markTaskAsComplete({{ $userTask->id }})">
                                                    Comment on Post
                                                </a>
                                            @elseif ($userTask->task->type === 'share')
                                                <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link text-warning text-decoration-none"
                                                    onclick="markTaskAsComplete({{ $userTask->id }})">
                                                    Share Post
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">No Link Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($userTask->task->url)) 
                                            <iframe 
                                                width="200" 
                                                height="100" 
                                                src="{{ Str::replace('watch?v=', 'embed/', $userTask->task->url) }}" 
                                                title="YouTube video player" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <span class="text-muted">No video available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($userTask->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $userTask->task->deadline }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $userTasks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function markTaskAsComplete(taskId) {
        fetch("{{ route('video.interaction') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                task_id: taskId,
                event_type: 'completed'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Interaction tracked successfully') {
                alert('Task marked as completed!');
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
