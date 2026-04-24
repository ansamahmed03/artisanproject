<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Artisan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ArtisanFactory> */
    use HasFactory , HasRoles, SoftDeletes;

      protected $fillable = [
       'artisan_name',
        'email',
        'password',
        'store_name',
         'city',
        'city_id',
           'bio',
         'bank_info',


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


///////////////////////////////////////////////////////////
public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable');
}



public function orders()
{
    return $this->hasManyThrough(Order::class, Product::class);
}

public function notifications()
{
    return $this->morphMany(Notification::class, 'notifiable');
}
/////////////////////////////////////////////////////////////













}
