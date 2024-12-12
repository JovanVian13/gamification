<!-- resources/views/admin/testimonials/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Daftar Testimonial</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Pengguna</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Ditampilkan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($testimonials as $testimonial)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $testimonial->user->name }}</td>
                    <td>{{ $testimonial->message }}</td>
                    <td>{{ $testimonial->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if($testimonial->is_featured)
                            <span class="badge bg-success">Ya</span>
                        @else
                            <span class="badge bg-secondary">Tidak</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.toggle-featured', $testimonial->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $testimonial->is_featured ? 'btn-danger' : 'btn-success' }}">
                                {{ $testimonial->is_featured ? 'Sembunyikan' : 'Tampilkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada testimonial.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $testimonials->links() }}
</div>
@endsection
