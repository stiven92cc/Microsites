<?php

namespace App\Infrastructure\Persistence\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $guarded = [];


    protected static function newFactory(): CategoryFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return CategoryFactory::new();
    }
}
