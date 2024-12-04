@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<!--<div class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <div class="card-header m-bg-secondary text-white">
            <h1 class="h3 mb-0 text-center">My Tasks</h1>
        </div>-->
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
                                        @php
                                            // Parsing YouTube ID
                                            $videoId = null;
                                            if (strpos($userTask->task->url, 'youtu.be') !== false) {
                                                $videoId = basename($userTask->task->url);
                                            } elseif (strpos($userTask->task->url, 'youtube.com') !== false) {
                                                parse_str(parse_url($userTask->task->url, PHP_URL_QUERY), $queryParams);
                                                $videoId = $queryParams['v'] ?? null;
                                            }
                                        @endphp

                                        @if ($userTask->task->type === 'video' && $videoId)
                                            <div class="ratio ratio-16x9">
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @elseif ($userTask->task->type === 'like' && $videoId)
                                            <div class="ratio ratio-16x9">
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @elseif ($userTask->task->type === 'comment' && $videoId)
                                            <div class="ratio ratio-16x9">
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @elseif ($userTask->task->type === 'share' && $videoId)
                                            <div class="ratio ratio-16x9">
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @else
                                            <span class="text-muted">Unknown Task Type or Invalid URL</span>
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
