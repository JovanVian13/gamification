<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Show feedback form
    public function showForm()
    {
        return view('feedback.form');
    }

    // Handle feedback submission
    public function submitFeedback(Request $request)
    {
        // Simulate saving feedback (dummy response)
        $feedback = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        // Return success message
        return back()->with('success', 'Feedback berhasil dikirim. Terima kasih!');
    }

    // Show FAQ
    public function showFaq()
    {
        // Dummy FAQ data
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
        ];

        return view('faq', compact('faq'));
    }

    // Show contact support page
    public function contactSupport()
    {
        return view('contact');
    }
}
