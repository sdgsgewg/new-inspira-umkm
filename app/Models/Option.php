<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'options';
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_options')->withTimestamps();
    }    

    public function values() {
        return $this->hasMany(OptionValue::class);
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
