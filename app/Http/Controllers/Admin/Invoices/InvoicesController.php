<?php

namespace App\Http\Controllers\Admin\Invoices;

use App\Constants\Roles;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\Invoice;
use App\Infrastructure\Persistence\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class InvoicesController extends Controller
{
    public function index(): Response
    {
        $canPay = true;
        if (auth()->user()->hasRole(Roles::ADMIN)) {
            $invoices = Invoice::all();
            $canPay = false;
        } else {
            $invoices = Invoice::all()->where('document',auth()->user()->document);
        }
        return Inertia::render('Invoices/Index', ['invoices' => $invoices, 'canPay' => $canPay]);
    }
}
