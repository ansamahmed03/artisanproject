<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'message',
        'is_read',
        'notifiable_id',
        'notifiable_type'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
