<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::resource('categories', CategoryController::class);
Route::resource('microsites', \App\Http\Controllers\Admin\Microsites\MicrositesController::class);
