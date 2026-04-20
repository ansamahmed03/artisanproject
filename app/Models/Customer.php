<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{

        use SoftDeletes;
        use HasFactory;
    protected $fillable = ['full_name', 'email', 'password'];

public function user() {
    return $this->morphOne(User::class, 'userable');
}
//

}
