<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->paginate(10);

        return view('admin.testimonials', compact('testimonials'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Testimonial::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Testimonial Anda telah dikirim.');
    }

    // Mengubah status featured testimonial
    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_featured = !$testimonial->is_featured;
        $testimonial->save();

        return redirect()->route('admin.testimonials')
                         ->with('success', 'Status testimonial berhasil diperbarui.');
    }
}
