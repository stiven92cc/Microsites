<?php

namespace App\Http\Controllers\Admin\Invoices;

use App\Constants\MicrositeTypes;
use App\Http\Controllers\Controller;
use App\Imports\InvoicesImport;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceImportController extends Controller
{
    public function importForm()
    {
        // Obtener los micrositios con id y nombre
        $microsites = Microsite::select('id', 'name')->where('type', MicrositeTypes::INVOICE)->get();

        // Enviar los micrositios a la vista
        return Inertia::render('Invoices/Import', [
            'microsites' => $microsites,
        ]);
    }

    public function import(Request $request)
    {
        // Validar que el archivo y el micrositio estén presentes
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'microsite_id' => 'required|exists:microsites,id' // Validar que el micrositio exista
        ]);

        // Pasar el ID del micrositio a la clase de importación
        Excel::import(new InvoicesImport($request->microsite_id), $request->file('file'));

        return response()->json(['message' => 'Invoices imported successfully']);
    }
}
