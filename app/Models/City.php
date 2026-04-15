<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory , SoftDeletes;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}
