@extends('layouts.userapp')

@section('title', 'FAQ')

@section('content')
<div class="container">
    <div class="card shadow rounded border-2 mb-4">
        <div class="card-header text-white text-center p-4">
            <h2 class="h4 mb-0 m-p-secondary">Frequently Asked Questions</h2>
        </div>
        <div class="accordion" id="faqAccordion">
            @php
                $faq = [
                    [
                        'question' => 'Bagaimana cara mendapatkan poin?',
                        'answer' => 'Anda bisa mendapatkan poin dengan menyelesaikan tugas seperti menonton video, memberikan like, atau membagikan konten.',
                    ],
                    [
                        'question' => 'Bagaimana cara menukar voucher?',
                        'answer' => 'Anda dapat menukar voucher melalui halaman "Penukaran Poin" setelah poin Anda mencukupi.',
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan jika tugas tidak diverifikasi?',
                        'answer' => 'Silakan hubungi customer support kami melalui halaman "Kontak" untuk bantuan lebih lanjut.',
                    ],
                    [
                        'question' => 'Bagaimana cara mendapatkan poin?',
                        'answer' => 'Anda bisa mendapatkan poin dengan menyelesaikan tugas seperti menonton video, memberikan like, atau membagikan konten.',
                    ],
                    [
                        'question' => 'Bagaimana cara menukar voucher?',
                        'answer' => 'Anda dapat menukar voucher melalui halaman "Penukaran Poin" setelah poin Anda mencukupi.',
                    ],
                ];
            @endphp
            @foreach ($faq as $index => $item)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                            {{ $item['question'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $item['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>  
    </div>
</div>
    <!-- Form Testimonials -->
    <div class="container mt-5">
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h4 class="text-center mb-4">Kirim Testimonial Anda</h4>
    
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
    
                <form action="{{ route('testimonials.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn m-btn-primary w-100">Kirim Testimonial</button>
                </form>
            </div>
        </div>
    </div>
@endsection
