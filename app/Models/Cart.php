<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['user', 'designs'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designs()
    {
    return $this->belongsToMany(Design::class, 'cart_designs')
                    ->withPivot('quantity', 'isChecked')
                    ->withTimestamps();
    }
}
