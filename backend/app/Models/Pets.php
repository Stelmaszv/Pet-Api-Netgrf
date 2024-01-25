<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pets extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'status','category_id'];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
