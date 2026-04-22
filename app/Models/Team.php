<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;
class Team extends Authenticatable
{
    //
    use SoftDeletes;
protected $fillable = ['team_name', 'email', 'password', 'bio', 'hourly_rate', 'city_id', 'status'];

    public function user() {
    return $this->morphOne(User::class, 'userable');
}
public function city()
    {
        return $this->belongsTo(City::class);
    }

/////////////////////////////////
public function bookings()
{
    return $this->hasMany(Booking::class);
}
/////////////////////////

}
