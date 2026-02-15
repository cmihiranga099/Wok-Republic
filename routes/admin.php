<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingController;

// Admin Routes go here

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('dishes', DishController::class);
Route::resource('addons', AddonController::class);
Route::resource('orders', OrderController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('offers', OfferController::class);
Route::resource('testimonials', TestimonialController::class);
Route::resource('gallery', GalleryController::class);

Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
