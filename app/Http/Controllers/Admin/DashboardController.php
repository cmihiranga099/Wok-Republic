<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Dish;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)->sum('total');
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::latest()->take(5)->get();
        $pendingReservationsList = Reservation::where('status', 'pending')->latest()->take(5)->get();

        $topDishes = Dish::withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take(5)
            ->get();

        $monthlyRevenue = Order::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->sum('total');

        return view('admin.dashboard', compact(
            'todayOrders', 'todayRevenue', 'pendingReservations', 'totalCustomers',
            'recentOrders', 'pendingReservationsList', 'topDishes', 'monthlyRevenue'
        ));
    }
}
