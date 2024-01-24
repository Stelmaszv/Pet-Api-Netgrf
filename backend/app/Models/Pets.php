<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $fillable = ['name', 'status'];

    public function category()
    {
        return $this->hasOne(Categories::class);
    }
}
