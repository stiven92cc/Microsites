<?php

use App\Http\Controllers\Admin\Microsites\MicrositesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/v1/microsites', MicrositesController::class);
