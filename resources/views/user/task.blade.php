@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h3 mb-0">My Tasks</h1>
        </div>
        <div class="card-body">
            @if($userTasks->isEmpty())
                <div class="text-center">
                    <strong>No tasks available.</strong>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Points</th>
                                <th>URL</th>
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
                                        @if ($userTask->task->url)
                                            <a href="{{ $userTask->task->url }}" target="_blank" class="btn btn-link">
                                                <i class="bi bi-box-arrow-up-right"></i> Open
                                            </a>
                                        @else
                                            <span class="text-muted">No URL</span>
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
@endsection
