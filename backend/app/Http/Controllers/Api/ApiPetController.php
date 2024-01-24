<?php

namespace App\Http\Controllers\Api;

use App\Models\Pets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiPetController extends Controller
{
    public function all()
    {
        return response()->json(['data' => Pets::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:aktywne,realizowane,w trakcie|max:255'
        ]);

        $pets = Pets::create([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        return response()->json(['data' => $pets], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:aktywne,realizowane,w trakcie|max:255'
        ]);

        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pets->update([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        return response()->json(['data' => $pets], 200);
    }

    public function destroy($id): JsonResponse
    {
        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pets->delete();

        return response()->json(['message' => 'Pet deleted successfully'], 200);
    }

    public function show($id): JsonResponse
    {
        $pets = Pets::find($id);

        if (!$pets) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        return response()->json(['data' => $pets], 200);
    }
}
