@extends('layouts.userapp')

@section('content')
<div class="container">

    <!-- Menampilkan Pesan Sukses atau Error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Katalog Voucher -->
    <div class="card shadow mb-4 border-2">
        <div class="card-header text-white text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Voucher Shop</h2>
        </div>
        <div class="card-body">
            <!-- Menampilkan Informasi Poin yang Dibutuhkan untuk Setiap Voucher -->
            <div class="row">
                @foreach($vouchers as $voucher)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">{{ $voucher->title }}</h6>
                                <p class="card-text">{{ $voucher->description }}</p>
                                <p class="card-text"><strong>{{ $voucher->points_required }} poin</strong></p>

                                <!-- Tombol Tukar jika Poin Cukup -->
                                @if($userPoints ?? 0 >= $voucher->points_required)
                                    <form action="{{ route('voucher.redeem.action', $voucher->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn m-btn-secondary">Tukar Voucher</button>
                                    </form>
                                @else
                                    <p class="text-muted">Poin tidak cukup.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Riwayat Penukaran Voucher -->
    <div class="card shadow mb-5 border-2">
        <div class="card-header text-white text-center py-3">
            <h4 class="card-title m-p-secondary">Riwayat Penukaran Voucher</h4>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse($userVouchers as $userVoucher)
                <li class="list-group-item d-flex justify-content-between align-items-center p-4">
                    <div>
                        <strong>{{ $userVoucher->voucher->title }}</strong> - 
                        <span class="badge bg-info text-dark">{{ $userVoucher->status }}</span>
                    </div>
                    <small class="ms-auto">{{ $userVoucher->redeemed_at ? 'Ditukar pada: ' . $userVoucher->redeemed_at : 'Belum Ditukar' }}</small>
                </li>

                @empty
                    <li class="list-group-item text-muted">Belum ada riwayat penukaran voucher.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
