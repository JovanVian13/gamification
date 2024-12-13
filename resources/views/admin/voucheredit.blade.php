@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Voucher</h1>
    <form action="{{ route('admin.voucherupdate', $voucher->id) }}" method="POST" id="voucher-edit-form">
        @csrf
        @method('PATCH')

        <!-- Nama Voucher -->
        <div class="mb-3">
            <label for="title" class="form-label">Nama Voucher</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $voucher->title }}" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ $voucher->description }}</textarea>
        </div>

        <!-- Poin yang Dibutuhkan -->
        <div class="mb-3">
            <label for="points_required" class="form-label">Poin yang Dibutuhkan</label>
            <input type="number" class="form-control" id="points_required" name="points_required" value="{{ $voucher->points_required }}" required>
        </div>

        <!-- Kode Voucher -->
        <div class="mb-3">
            <label for="code" class="form-label">Kode Voucher</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $voucher->code }}" required>
        </div>

        <!-- Tanggal Kadaluarsa -->
        <div class="mb-3">
            <label for="expired_date" class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" class="form-control" id="expired_date" name="expired_date" value="{{ $voucher->expired_date }}" required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" readonly>
                <option value="active" {{ $voucher->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ $voucher->status === 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const expiredDateInput = document.getElementById('expired_date');
        const statusSelect = document.getElementById('status');

        expiredDateInput.addEventListener('change', function () {
            const expiredDate = new Date(expiredDateInput.value);
            const today = new Date();

            // Jika tanggal kadaluarsa di masa depan, status active. Jika di masa lalu, status expired.
            if (expiredDate > today) {
                statusSelect.value = 'active';
            } else {
                statusSelect.value = 'expired';
            }
        });
    });
</script>
@endsection
