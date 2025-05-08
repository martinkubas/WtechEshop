<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'images',
        'release_year',
        'platforms',
        'genres'
    ];
    
    protected $casts = [
        'images' => 'array',
        'platforms' => 'array',
        'genres' => 'array',
    ];
}
