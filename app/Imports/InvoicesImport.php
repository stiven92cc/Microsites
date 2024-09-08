<?php

namespace App\Imports;

use App\Infrastructure\Persistence\Models\Invoice;
use App\Infrastructure\Persistence\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoicesImport implements ToModel, WithHeadingRow
{
    protected $micrositeId;

    public function __construct($micrositeId)
    {
        $this->micrositeId = $micrositeId;
    }

    public function model(array $row)
    {
        $user = User::where('document', $row['document'])->first();

        if (!$user) {
            throw new \Exception("Usuario con documento {$row['document']} no encontrado.");
        }

        // Crear la factura y asociarla al usuario
        return new Invoice([
            'user_id' => $user->id,
            'name' => $row['name'],
            'microsite_id' => $this->micrositeId,
            'reference' => $row['reference'],
            'description' => $row['description'],
            'number' => $row['number'],
            'status' => $row['status'],
            'email' => $row['email'],
            'amount' => $row['amount'],
            'currency' => $row['currency'],
            'phone_number' => $row['phone_number'],
            'document_type' => $row['document_type'],
            'expired_at' => Carbon::now()->addMonth()->startOfDay(),
            'document' => $row['document'],
        ]);
    }
}
