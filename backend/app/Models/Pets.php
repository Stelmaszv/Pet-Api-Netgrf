<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $fillable = ['name', 'status','category_id'];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
