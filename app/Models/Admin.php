<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;
class Admin extends Authenticatable
{
    //
       use HasRoles;
        use SoftDeletes;

    protected $fillable = ['full_name', 'email', 'password'];

public function user() {
    return $this->morphOne(User::class, 'userable');
}




}

