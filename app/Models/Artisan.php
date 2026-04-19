<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Artisan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ArtisanFactory> */
    use HasFactory , HasRoles, SoftDeletes;

      protected $fillable = [
        'name',
        'city_id',


    ];

      protected $hidden = [
        'password',
        'email',
        'bank_info',
    ];



public function user() {
    return $this->morphOne(User::class, 'userable');
}
protected static function booted()
{
    static::deleting(function ($artisan) {


        // سيتم حذف اليوزر تلقائياً بمجرد استدعاء حذف الأرتزان
        if ($artisan->user) {
            $artisan->user->delete();
        }
    });


}
public function city()
{
    return $this->belongsTo(City::class, 'city_id');
}


public function products()
{
    return $this->hasMany(Product::class);
}
}
