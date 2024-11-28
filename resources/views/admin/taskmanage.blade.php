@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
<div class="container">
    <h1>Task Management</h1>
    <a href="{{ route('admin.taskcreate') }}" class="btn btn-primary mb-3">Create Task</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Type</th>
                <th>Points</th>
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
</div>
@endsection
