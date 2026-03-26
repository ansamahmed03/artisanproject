<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    /** @use HasFactory<\Database\Factories\ArtisanFactory> */
    use HasFactory;

      protected $fillable = [
        'name',
        'store_name',
        'bio',
        'city',
        'bank_info',

    ];

      protected $hidden = [
        'password',
        'email',
        'bank_info',
    ];
}
