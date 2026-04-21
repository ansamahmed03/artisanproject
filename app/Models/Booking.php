<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['booking_date', 'status', 'notes', 'customer_id', 'team_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}