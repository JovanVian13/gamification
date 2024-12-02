@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
<div class="container mt-5">
    <h1>Task Management</h1>
    <a href="{{ route('admin.taskcreate') }}" class="btn btn-primary mb-3">Create Task</a>
    @if($tasks->isEmpty())
        <div class="alert alert-warning">
            No tasks found.
        </div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Points</th>
                    <th>URL</th> <!-- Tambahkan Kolom -->
                    <th>Assigned Users</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->type) }}</td>
                    <td>{{ $task->points }}</td>
                    <td>
                        @if ($task->url)
                            <a href="{{ $task->url }}" target="_blank">{{ $task->url }}</a>
                        @else
                            No URL
                        @endif
                    </td>
                    <td>{{ $task->userTasks ? $task->userTasks->count() : 0 }} Users</td>
                    <td>{{ $task->deadline ? $task->deadline->format('Y-m-d H:i') : 'No Deadline' }}</td>
                    <td>
                        <a href="{{ route('admin.taskedit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.taskdelete', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    @endif
</div>
@endsection
