<?php

namespace App\Http\Controllers\Api;

use App\Models\Categories;
use App\Http\Controllers\Controller;

class ApiCategoryController  extends Controller
{
    public function all()
    {
        return response()->json(['data' => Categories::all()]);
    }

}
