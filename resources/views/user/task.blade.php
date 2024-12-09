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
                                <th>Status</th>
                                <th>Points</th>
                                <th>Link Tugas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTasks as $userTask)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $userTask->task->title }}</td>
                                    <td>
                                        @if($userTask->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $userTask->task->points }}</td>
                                    <td>
                                        @if (!empty($userTask->task->url))
                                        <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link text-primary text-decoration-none"
                                           onclick="markTaskAsComplete({{ $userTask->id }})">
                                            Watch Video
                                        </a>
                                        @else
                                        <span class="text-muted">No Video</span>
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
    </div>
</div>

<script>
    function markTaskAsComplete(taskId) {
        // Menggunakan AJAX untuk menandai tugas sebagai selesai
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
            // Periksa apakah status berhasil diperbarui
            if (data.message === 'Interaction tracked successfully') {
                alert('Task marked as completed!');
                location.reload(); // Reload halaman untuk memperbarui status tugas
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
