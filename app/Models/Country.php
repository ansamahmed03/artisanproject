<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory , SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   public function City(){

    return $this->hasMany(City::class , "country_id" , "id");
    }



}
