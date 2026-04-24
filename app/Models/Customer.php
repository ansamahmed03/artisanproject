<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
class Customer extends Authenticatable
{
         use HasRoles;
        use SoftDeletes;
        use HasFactory;
    protected $fillable = ['full_name', 'email', 'password'];

public function user() {
    return $this->morphOne(User::class, 'userable');
}
//



//////////////////////////////////////

public function orders()
{
    return $this->hasMany(Order::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

public function carts()
{
    return $this->hasMany(Cart::class);
}

public function notifications()
{
    return $this->morphMany(Notification::class, 'notifiable');
}
//////////////////////////////////////////
}
