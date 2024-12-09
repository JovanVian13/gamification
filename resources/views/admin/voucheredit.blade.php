@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Voucher</h1>
    <form action="{{ route('admin.voucherupdate', $voucher->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label">Nama Voucher</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $voucher->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ $voucher->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="points_required" class="form-label">Poin yang Dibutuhkan</label>
            <input type="number" class="form-control" id="points_required" name="points_required" value="{{ $voucher->points_required }}" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Kode Voucher</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $voucher->code }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" {{ $voucher->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="expired" {{ $voucher->status == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection