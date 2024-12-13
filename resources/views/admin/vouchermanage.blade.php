@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Voucher</h1>
    <a href="{{ route('admin.vouchercreate') }}" class="btn m-btn-primary mb-3">Buat Voucher Baru</a>

    <!-- Menampilkan Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Voucher -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Voucher</th>
                <th>Kode</th>
                <th>Poin</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vouchers as $voucher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $voucher->title }}</td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->points_required }}</td>
                    <td>{{ \Carbon\Carbon::parse($voucher->expired_date)->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $voucher->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.voucheredit', $voucher->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.voucherdelete', $voucher->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus voucher ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada voucher yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $vouchers->links() }}
    </div>
</div>
@endsection
