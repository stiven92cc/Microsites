<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microsite extends Model
{
    use HasFactory;

    protected $table = 'microsites';

    protected $guarded = [

    ];

}
