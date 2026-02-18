<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DishImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = DishImage::with('dish')->latest()->paginate(20);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'images' => 'required|array',
            'images.*' => 'image|max:2048',
        ]);

        foreach ($request->file('images') as $image) {
            DishImage::create([
                'dish_id' => $request->dish_id,
                'image_path' => $image->store('dishes', 'public'),
                'is_thumbnail' => false,
            ]);
        }

        return redirect()->route('gallery.index')->with('success', 'Images uploaded successfully.');
    }

    public function show(DishImage $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit(DishImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, DishImage $gallery)
    {
        $request->validate(['is_thumbnail' => 'boolean']);
        $gallery->update(['is_thumbnail' => $request->has('is_thumbnail')]);
        return redirect()->route('gallery.index')->with('success', 'Image updated.');
    }

    public function destroy(DishImage $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Image deleted.');
    }
}
