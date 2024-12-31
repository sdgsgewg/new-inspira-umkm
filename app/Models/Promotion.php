<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'promotions';
    protected $guarded = ['id'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'promotion_plans');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_promotions')
        ->withPivot('id', 'quantity', 'sub_total_price')
        ->withTimestamps();
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
