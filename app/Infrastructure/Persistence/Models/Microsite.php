<?php

namespace App\Infrastructure\Persistence\Models;

use Database\Factories\MicrositeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Microsite extends Model
{
    use HasFactory;

    protected $table = 'microsites';

    protected $guarded = [

    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory()
    {
        return MicrositeFactory::new();
    }
}
