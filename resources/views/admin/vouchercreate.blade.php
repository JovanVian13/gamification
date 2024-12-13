@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Buat Voucher Baru</h1>
    <form action="{{ route('admin.voucherstore') }}" method="POST">
        @csrf

        <!-- Nama Voucher -->
        <div class="mb-3">
            <label for="title" class="form-label">Nama Voucher</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <!-- Poin yang Dibutuhkan -->
        <div class="mb-3">
            <label for="points_required" class="form-label">Poin yang Dibutuhkan</label>
            <input type="number" class="form-control" id="points_required" name="points_required" value="{{ old('points_required') }}" required>
        </div>

        <!-- Kode Voucher -->
        <div class="mb-3">
            <label for="code" class="form-label">Kode Voucher</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
        </div>

        <!-- Tanggal Kadaluarsa -->
        <div class="mb-3">
            <label for="expired_date" class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" class="form-control" id="expired_date" name="expired_date" value="{{ old('expired_date') }}" required>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
