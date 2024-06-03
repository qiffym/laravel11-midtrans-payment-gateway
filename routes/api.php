<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/donation', [Controllers\DonationController::class, 'store'])->name('donations.store');
Route::post('/midtrans/notification', [Controllers\DonationController::class, 'notification'])->name('donations.notification');
