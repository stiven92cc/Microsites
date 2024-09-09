<?php

namespace App\Http\Controllers\Guest;

use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController
{
    public function index(Request $request)
    {
        $microsites = Cache::remember('guest.microsites', 60 * 60, function () {
            return Microsite::with(['category:id,name'])
                ->select('id', 'name', 'logo', 'category_id')
                ->get();
        });

        if ($search = $request->input('search')) {
            $microsites = $microsites->filter(function ($microsite) use ($search) {
                return stripos($microsite->name, $search) !== false;
            });
        }
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'microsites' => $microsites,
            'search' => $search,
        ]);
    }

}
