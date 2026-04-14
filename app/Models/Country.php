<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   public function City(){

    return $this->hasMany(Country::class , "country_id" , "id");
    }



}
