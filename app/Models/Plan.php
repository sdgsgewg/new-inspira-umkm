<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_plans');
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
