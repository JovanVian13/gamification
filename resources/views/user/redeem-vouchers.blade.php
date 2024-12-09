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
    <div class="card shadow mb-5 border-2">
        <div class="card-header text-white text-center py-3">
            <h4 class="card-title m-p-secondary">Riwayat Penukaran Voucher</h4>
        </div>
        <div class="card-body">
            <div class="accordion" id="redeemedVoucherAccordion">
                @forelse($userVouchers as $index => $userVoucher)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRedeemed{{ $index }}">
                            <button class="accordion-button collapsed" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapseRedeemed{{ $index }}" 
                                    aria-expanded="false" 
                                    aria-controls="collapseRedeemed{{ $index }}">
                                <div class="row w-100">
                                    <div class="col-4 d-flex align-items-center">
                                        <strong>{{ $userVoucher->voucher->title }}</strong>
                                    </div>
                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                        <span class="badge bg-info text-dark">{{ $userVoucher->status }}</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end align-items-center">
                                        <small>{{ $userVoucher->redeemed_at ? $userVoucher->redeemed_at : 'Belum Ditukar' }}</small>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseRedeemed{{ $index }}" class="accordion-collapse collapse" 
                            aria-labelledby="headingRedeemed{{ $index }}" 
                            data-bs-parent="#redeemedVoucherAccordion">
                            <div class="accordion-body">
                                @if($userVoucher->status === 'redeemed')
                                    <span class="text-success">Kode Voucher:</span> 
                                    <strong>{{ $userVoucher->voucher->code }}</strong>
                                @else
                                    <span class="text-muted">Belum memiliki kode voucher.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada riwayat penukaran voucher.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
