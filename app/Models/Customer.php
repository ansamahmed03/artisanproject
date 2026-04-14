<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{


    protected $fillable = ['full_name', 'email', 'password'];

public function user() {
    return $this->morphOne(User::class, 'userable');
}
//
}
