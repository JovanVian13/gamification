@extends('layouts.userapp')

@section('title', 'FAQ')

@section('content')
<div class="container">
    <div class="card-header m-bg-primary text-white text-center p-4">
        <h2 class="h4 mb-0">Frequently Asked Questions</h2>
    </div>
    <div class="accordion mb-5" id="faqAccordion">
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
@endsection
