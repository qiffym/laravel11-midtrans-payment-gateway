<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\DonationController::class, 'index'])->name('donations.index');
Route::get('/donation', [Controllers\DonationController::class, 'create'])->name('donations.create');
Route::post('/donation', [Controllers\DonationController::class, 'store'])->name('donations.store');
