@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Buat Voucher Baru</h1>
    <form action="{{ route('admin.voucherstore') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Nama Voucher</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="points_required" class="form-label">Poin yang Dibutuhkan</label>
            <input type="number" class="form-control" id="points_required" name="points_required" value="{{ old('points_required') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
