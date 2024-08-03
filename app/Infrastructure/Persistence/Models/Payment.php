<?php

namespace App\Infrastructure\Persistence\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $guarded = [

    ];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }
    protected static function newFactory(): PaymentFactory
    {
        return PaymentFactory::new();
    }
}
