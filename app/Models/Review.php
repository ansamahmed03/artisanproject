<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
  use SoftDeletes;

    protected $fillable = ['rating', 'comment', 'reviewable_id', 'reviewable_type', 'customers_id'];

    // العلاقة polymorphic
    public function reviewable()
    {
        return $this->morphTo();
    }

    // العلاقة مع Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }
}
