<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    /** @use HasFactory<\Database\Factories\ArtisanFactory> */
    use HasFactory;

      protected $fillable = [
        'name',
        'store_name',
        'bio',
        'city',
        'bank_info',

    ];

      protected $hidden = [
        'password',
        'email',
        'bank_info',
    ];



    public function user()
{
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
}
