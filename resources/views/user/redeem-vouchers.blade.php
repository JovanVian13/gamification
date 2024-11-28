@extends('layouts.homeapp')

@section('content')
<div class="container mt-4">
    <!-- Katalog Voucher -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Katalog Voucher</h5>

            <!-- Menampilkan Informasi Poin yang Dibutuhkan untuk Setiap Voucher -->
            <div class="row">
                @foreach($vouchers as $voucher)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">{{ $voucher->name }}</h6>
                                <p class="card-text">{{ $voucher->description }}</p>
                                <p class="card-text"><strong>{{ $voucher->points_required }} poin</strong></p>

                                <!-- Tombol Tukar jika Poin Cukup -->
                                @if($userPoints >= $voucher->points_required)
                                    <form action="{{ route('voucher.redeem', $voucher->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Tukar Voucher</button>
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
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Riwayat Penukaran Voucher</h5>
            
            <ul class="list-group">
                @foreach($redemptions as $redemption)
                    <li class="list-group-item">
                        <strong>{{ $redemption->voucher->name }}</strong> - 
                        {{ $redemption->status }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
