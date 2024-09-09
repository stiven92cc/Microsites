<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Invoices\InvoiceImportController;
use App\Http\Controllers\Admin\Invoices\InvoicesController;
use App\Http\Controllers\Admin\Microsites\MicrositesController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Guest\WelcomeController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Subscription\SubscriptionPlanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/payment/{microsite}', [PaymentController::class, 'micrositeForm'])->name('payment.form');
Route::post('/payment/{microsite}', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/invoice/{invoice}', [PaymentController::class, 'payInvoice'])->name('payment.pay.invoice');
Route::get('/payment/detail/{payment}', [PaymentController::class, 'detail'])->name('payment.detail');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('microsites', MicrositesController::class);
    Route::post('store/microsite/logo{id}', [MicrositesController::class, 'update'])
            ->name('microsites.update.temp');
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UsersController::class);
    Route::resource('roles', RolesController::class);


    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('subscription-plans/create/{id}', [SubscriptionPlanController::class, 'create'])
    ->name('subscription-plans.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('payments', PaymentController::class);
    Route::post('/invoices/import', [InvoiceImportController::class, 'import']);
    Route::get('/invoices/import', [InvoiceImportController::class, 'importForm'])->name('import.form');
    Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
    Route::post('/subscription/{id}/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

});

require __DIR__.'/auth.php';
