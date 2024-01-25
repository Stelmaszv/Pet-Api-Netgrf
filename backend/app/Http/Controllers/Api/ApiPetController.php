<?php

namespace App\Http\Controllers\Api;

use App\Models\Pets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiPetController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return response()->json(['data' => Pets::all()]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:wyleczony,leczenie|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $pets = Pets::create($validatedData);

        return response()->json(['data' => $pets], 201);
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:wyleczony,leczenie|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pets->update($validatedData);

        return response()->json(['data' => $pets], 200);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pets->delete();

        return response()->json(['message' => 'Pet deleted successfully'], 200);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        return response()->json(['data' => $pets], 200);
    }
}
