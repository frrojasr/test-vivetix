<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SaleController;





Route::get('/home', function () {
    return view('layouts.app');
})->name('home');




Route::group(['middleware' => 'web'], function () {
    // Tus rutas aquí


    Route::get('/event', [EventController::class, 'list'])->name('event.list');

    Route::post('/event', [EventController::class, 'store'])->name('event.store');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales');

    Route::post('/sales', [SaleController::class, 'store'])->name('sale.store');
});
