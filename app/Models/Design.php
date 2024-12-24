<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Design extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['product', 'category', 'seller'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function options()
    {
        return $this->belongsToMany(OptionValue::class, 'design_options')->withTimestamps();
    }

    public function seller() 
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_designs')
        ->withPivot('quantity', 'isChecked')
        ->withTimestamps();
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_designs')
        ->withPivot('id', 'quantity', 'sub_total_price')
        ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(DesignReview::class, 'design_id', 'id');
    }

    public function reviewByUser($userId)
    {
        return $this->reviews()->where('user_id', $userId)->first();
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
