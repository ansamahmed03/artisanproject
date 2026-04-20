<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artisan extends Model
{
    /** @use HasFactory<\Database\Factories\ArtisanFactory> */
    use HasFactory , SoftDeletes;

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


public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable');
}



    /////////////////
public function notifications()
{
    return $this->morphMany(Notification::class, 'notifiable');
}
///////////////////////////

}
