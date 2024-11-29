@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Voucher</h1>
    <a href="{{ route('admin.vouchercreate') }}" class="btn btn-primary mb-3">Buat Voucher Baru</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Voucher</th>
                <th>Kode</th>
                <th>Poin</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vouchers as $voucher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $voucher->title }}</td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->points_required }}</td>
                    <td>
                        <span class="badge bg-{{ $voucher->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.voucheredit', $voucher->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.voucherdelete', $voucher->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Hapus voucher ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
