<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $popularDishes = Dish::where('status', true)->inRandomOrder()->take(4)->get();
        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('status', true)->latest()->take(6)->get();

        return view('frontend.home', compact('popularDishes', 'categories', 'testimonials'));
    }
}
