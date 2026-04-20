<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['total_price', 'order_status', 'customer_id', 'address_id'];

    public function customer()   { return $this->belongsTo(Customer::class); }
    public function address()    { return $this->belongsTo(Address::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
}