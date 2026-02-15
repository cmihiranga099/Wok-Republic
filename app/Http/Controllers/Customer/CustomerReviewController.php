<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Dish;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    public function create(string $dish_slug): View
    {
        $dish = Dish::where('slug', $dish_slug)->firstOrFail();
        // You might want to add logic here to check if the user has ordered this dish
        return view('customer.reviews.create', compact('dish'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'dish_id' => $request->dish_id,
            // Assuming order_id can be determined or is nullable
            'order_id' => null, // Placeholder, actual logic needed to link to a specific order item
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => true, // Auto-approve for now, can be moderated later
        ]);

        return redirect()->route('customer.orders.index')->with('success', 'Review submitted successfully!');
    }
}
