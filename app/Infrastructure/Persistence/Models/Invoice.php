<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'microsite_id',
        'expired_at',
        'status',
        'description',
        'name',
        'reference',
        'number',
        'email',
        'amount',
        'currency',
        'phone_number',
        'document_type',
        'document',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function microsite()
    {
        return $this->belongsTo(Microsite::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
