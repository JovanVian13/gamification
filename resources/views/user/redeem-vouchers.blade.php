@extends('layouts.userapp')

@section('content')
<div class="container mt-4">

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
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Voucher Shop</h5>

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
                                        <button type="submit" class="btn m-btn-primary">Tukar Voucher</button>
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
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title">Riwayat Penukaran Voucher</h5>
            
            <ul class="list-group">
                @forelse($userVouchers as $userVoucher)
                    <li class="list-group-item">
                        <strong>{{ $userVoucher->voucher->title }}</strong> - 
                        <span class="badge bg-info text-dark">{{ $userVoucher->status }}</span>
                        <br>
                        <small>Ditukar pada: {{ $userVoucher->redeemed_at ?? 'Belum Ditukar' }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Belum ada riwayat penukaran voucher.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
