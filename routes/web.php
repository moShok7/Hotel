<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('hotels', [HotelController::class , 'index'])->name('hotels.index');
Route::get('hotels/{hotel}' , [HotelController::class , 'show'])->name('hotels.show');
Route::get('/bookings' , [BookingController::class , 'index'])->name('bookings.index');
Route::post('/bookings' , [BookingController::class , 'store'])->name('bookings.store');
Route::get('/bookings/{booking}' , [BookingController::class , 'show'])->name('bookings.show');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
