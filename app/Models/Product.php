<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
use SoftDeletes;
protected $fillable = [
    'name',
    'description',
    'price',
    'stock_quantity',
    'category_id',
    'artisan_id',
    'status',
];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function category()
{
    return $this->belongsTo(Category::class);
}

public function artisan()
{
    return $this->belongsTo(Artisan::class);
}



public function images()
{
    return $this->hasMany(ProductImage::class);
}

/**public function images()
{
    return $this->morphMany(Image::class, 'imageable');
}

// جلب تقييمات المنتج (علاقة Polymorphic)
public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable');
}**/
}