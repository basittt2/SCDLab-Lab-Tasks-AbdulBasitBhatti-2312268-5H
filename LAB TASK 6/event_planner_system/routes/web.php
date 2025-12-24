<?php

use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/details/{id}', [EventController::class, 'details'])->name('events.details');
Route::get('/create', [EventController::class, 'create'])->name('events.create');
Route::post('/store', [EventController::class, 'store'])->name('events.store');
