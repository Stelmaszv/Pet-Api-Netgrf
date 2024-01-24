<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
