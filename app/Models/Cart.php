<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← ضيفي هاد

class Cart extends Model
{
    use SoftDeletes; // ← وهاد

    protected $fillable = ['customer_id', 'product_id', 'quantity'];

    public function product() { return $this->belongsTo(Product::class)->withDefault(['name' => 'Deleted Product']); }
    public function customer() { return $this->belongsTo(Customer::class); }
}
