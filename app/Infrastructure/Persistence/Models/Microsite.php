<?php

namespace App\Infrastructure\Persistence\Models;

use Database\Factories\MicrositeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function subscriptionPlans(): HasMany
    {
        return $this->hasMany(SubscriptionPlan::class);
    }



}
