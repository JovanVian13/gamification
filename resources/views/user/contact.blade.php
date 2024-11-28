@extends('layouts.userapp')

@section('title', 'Kontak Customer Support')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container custom-margin-top">
    <div class="text-center mb-3">
        <h3 class="fw-bold">Kontak Customer Support</h3>
        <p class="text-muted">Kami siap membantu Anda! Silakan hubungi kami melalui salah satu metode berikut.</p>
    </div>

    <div class="row justify-content-center">
        <!-- Email Contact -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center border-0">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="bi bi-envelope-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Email</h5>
                    <p class="card-text text-muted">
                        Kirimkan pertanyaan Anda miliki melalui email kami.
                    </p>
                    <a href="mailto:support@website.com" class="btn btn-primary">
                        Kirim Email
                    </a>
                </div>
            </div>
        </div>

        <!-- WhatsApp Contact -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center border-0">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="bi bi-whatsapp text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">WhatsApp</h5>
                    <p class="card-text text-muted">
                        Hubungi kami melalui WhatsApp untuk respons cepat.
                    </p>
                    <a href="https://wa.me/123456789" class="btn btn-success">
                        Kirim Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Additional Message -->
    <div class="text-center mt-5">
        <p class="text-muted">
            <small>Jam operasional: Senin - Jumat, pukul 09:00 - 17:00 WIB</small>
        </p>
    </div>
</div>
@endsection
