<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'ingredients',
        'allergens',
        'veg_non_veg',
        'spicy_level',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(DishImage::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'dish_addon');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
