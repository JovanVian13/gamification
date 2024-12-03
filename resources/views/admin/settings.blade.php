@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="container">
    <h1>General Settings</h1>
    <p>Kelola pengaturan umum platform di bawah ini.</p>

    <!-- Pengaturan Poin -->
    <div class="card my-4">
        <div class="card-header">
            <h5>Pengaturan Poin</h5>
        </div>
    </div>

    <!-- Pengaturan Waktu -->
    <div class="card my-4">
        <div class="card-header">
            <h5>Pengaturan Waktu</h5>
        </div>
        <div class="card-body">
        </div>
    </div>

    <!-- Pengaturan Email -->
    <div class="card my-4">
        <div class="card-header">
            <h5>Pengaturan Email</h5>
        </div>
        <div class="card-body">
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="mt-4 text-end">
        <button type="submit" class="btn m-btn-primary">Simpan Pengaturan</button>
    </div>
</div>
@endsection