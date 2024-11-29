@extends('layouts.userapp')

@section('title', 'Daftar Tugas')

@section('content')
<div class="container mt-4 mb-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Daftar Tugas</h3>
        <p class="text-muted">Pilih tugas untuk diselesaikan dan dapatkan poin!</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tugas</th>
                        <th>Jenis</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ ucfirst($task->type) }}</td>
                            <td>{{ $task->points }} poin</td>
                            <td>
                                <span class="badge 
                                    {{ $task->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($task->status === 'incomplete')
                                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                        @csrf
                                        <button class="btn m-btn-primary btn-sm">Selesaikan</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada tugas yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
