<?php

namespace App\Domain\Forms;

class CreateFormConfiguration
{
    public function create(string $micrositeType): mixed
    {
        $filePath = match ($micrositeType) {
            'donation' => base_path('app/Files/donation.json'),
            'subscription' => base_path('app/Files/subscription.json'),
            'invoice' => base_path('app/Files/invoice.json'),
            default => throw new \InvalidArgumentException("Unsupported form type: $micrositeType"),
        };

        $fileContents = file_get_contents($filePath);
        $decodedContents = json_decode($fileContents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON in file: ' . $filePath);
        }

        return $decodedContents;
    }
}
