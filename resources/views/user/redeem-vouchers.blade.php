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
    <div class="card shadow mb-4 border-2" style="min-height: 480px;">
        <div class="card-header text-white text-center py-3">
            <h2 class="h4 mb-0 m-p-secondary">Voucher Shop</h2>
        </div>
        <div class="card-body position-relative">
            <!-- Carousel Wrapper -->
            <div id="voucherCarousel" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    @foreach($vouchers->chunk(6) as $index => $voucherChunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($voucherChunk as $voucher)
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $voucher->title }}</h6>
                                                <p class="card-text">{{ $voucher->description }}</p>
                                                <p class="card-text"><strong>{{ $voucher->points_required }} poin</strong></p>
    
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
                    @endforeach
                </div>
            </div>
            <!-- Carousel Controls -->
            <button class="carousel-control-prev btn m-btn-primary" type="button" data-bs-target="#voucherCarousel" data-bs-slide="prev" style="width: 45px; height: 45px; top: 42%; left: -1rem;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next btn m-btn-primary" type="button" data-bs-target="#voucherCarousel" data-bs-slide="next" style="width: 45px; height: 45px; top: 42%; right: -1rem">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    

    <!-- Riwayat Penukaran Voucher -->
    <div class="card shadow mb-5 border-2" style="min-height: 430px;">
        <div class="card-header text-white text-center py-3">
            <h4 class="card-title m-p-secondary">Riwayat Penukaran Voucher</h4>
        </div>
        <div class="card-body position-relative">
            <!-- Carousel Wrapper -->
            <div id="redeemedVoucherCarousel" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    @foreach($userVouchers->chunk(6) as $chunkIndex => $voucherChunk)
                        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                            <div class="accordion" id="redeemedVoucherAccordion{{ $chunkIndex }}">
                                @foreach($voucherChunk as $index => $userVoucher)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingRedeemed{{ $chunkIndex }}{{ $index }}">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseRedeemed{{ $chunkIndex }}{{ $index }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseRedeemed{{ $chunkIndex }}{{ $index }}">
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
                                        <div id="collapseRedeemed{{ $chunkIndex }}{{ $index }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="headingRedeemed{{ $chunkIndex }}{{ $index }}"
                                            data-bs-parent="#redeemedVoucherAccordion{{ $chunkIndex }}">
                                            <div class="accordion-body">
                                                @if($userVoucher->status === 'redeemed')
                                                    <span class="text-success">Kode Voucher:</span>
                                                    <strong>{{ $userVoucher->voucher->code }}</strong>
                                                    <p><span class="text-danger">Berlaku hingga:</span>
                                                        <strong>{{ \Carbon\Carbon::parse($userVoucher->expired_date)->format('d-m-Y') }}</strong>
                                                    </p>
                                                @else
                                                    <span class="text-muted">Belum memiliki kode voucher.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Carousel Controls -->
            <button class="carousel-control-prev btn m-btn-primary" type="button" data-bs-target="#redeemedVoucherCarousel" data-bs-slide="prev" style="width: 45px; height: 45px; top: 42%; left: -1rem;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next btn m-btn-primary" type="button" data-bs-target="#redeemedVoucherCarousel" data-bs-slide="next" style="width: 45px; height: 45px; top: 42%; right: -1rem">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

@endsection
