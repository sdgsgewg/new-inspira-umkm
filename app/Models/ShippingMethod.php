<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'shipping_methods';
    protected $guarded = ['id'];

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
}
