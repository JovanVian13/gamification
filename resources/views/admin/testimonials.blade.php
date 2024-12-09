@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Daftar Testimonial</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Pengguna</th>
                <th>Pesan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($testimonials as $testimonial)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $testimonial->user->name }}</td>
                    <td>{{ $testimonial->message }}</td>
                    <td>{{ $testimonial->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada testimonial.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
