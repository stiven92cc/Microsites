<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'amount',
        'currency',
        'subscription_period',
        'expiration_time',
        'additional_info',
        'expiration_additional_info',
        'microsite_id',
    ];

    protected $casts = [
        'description' => 'array',
        'amount' => 'decimal:2',
        'subscription_period' => 'string',
    ];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }

}
