<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Microsites\MicrositesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
Route::middleware('auth')->group(function () {
    Route::resource('microsites', MicrositesController::class);
});

Route::resource('categories', CategoryController::class);
Route::resource('microsites', \App\Http\Controllers\Admin\Microsites\MicrositesController::class);
require __DIR__.'/auth.php';
