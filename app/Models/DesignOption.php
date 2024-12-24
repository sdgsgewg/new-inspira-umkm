<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignOption extends Model
{
    use HasFactory;

    protected $table = 'design_options';
    protected $guarded = ['id'];

    public function design()
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValue() {
        return $this->belongsTo(OptionValue::class);
    }
}
