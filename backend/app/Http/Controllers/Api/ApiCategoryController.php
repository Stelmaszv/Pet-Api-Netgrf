<?php

namespace App\Http\Controllers\Api;

use App\Models\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiCategoryController  extends Controller
{
    public function all()
    {
        return response()->json(['data' => Categories::all()]);
    }

    public function show($id): JsonResponse
    {
        $pets = Categories::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json(['data' => $pets], 200);
    }

}
