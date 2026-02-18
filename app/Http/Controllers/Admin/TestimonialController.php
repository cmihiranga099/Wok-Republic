<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::when($request->status !== null, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'testimonial_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'boolean',
        ]);

        Testimonial::create([
            'customer_name' => $request->customer_name,
            'testimonial_text' => $request->testimonial_text,
            'rating' => $request->rating,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial created.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'testimonial_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'boolean',
        ]);

        $testimonial->update([
            'customer_name' => $request->customer_name,
            'testimonial_text' => $request->testimonial_text,
            'rating' => $request->rating,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted.');
    }
}
