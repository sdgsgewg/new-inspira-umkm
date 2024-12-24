<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function designs() 
    {
        return $this->hasMany(Design::class);
    }

    public function categories() 
    {
        return $this->hasMany(Category::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options')->withTimestamps();
    }    

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
