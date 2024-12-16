@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
<div class="container mt-5">
    <h1>Task Management</h1>
    <a href="{{ route('admin.taskcreate') }}" class="btn m-btn-primary mb-3">Create Task</a>
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
                    <th>URL</th>
                    <th>Assigned Users</th>
                    <th>Deadline</th>
                    <th>Completed</th>
                    <th>Assign</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
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
                    <td>{{ $task->assigned_count ?? 0 }} Users</td>
                    <td>{{ $task->deadline ?? 'No Deadline' }}</td>
                    <td>{{ $task->completed_count ?? 0 }} Completed</td>
                    <td>
                        <form action="{{ route('admin.tasksassign', $task->id) }}" method="POST">
                            @csrf
                            <select name="user_id" required>
                                <option value="">Select User</option>
                                <option value="all">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success btn-sm">Assign Task</button>
                        </form>
                    </td>
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
