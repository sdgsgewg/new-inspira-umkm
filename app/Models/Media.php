<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = ['id'];

    // Polymorphic relationship
    public function medially()
    {
        return $this->morphTo();
    }
}
