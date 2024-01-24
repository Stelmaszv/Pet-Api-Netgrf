<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ApiPetController;
use App\Http\Controllers\Api\ApiCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home']);
Route::get('api/pets', [ApiPetController::class, 'all']);
Route::post('api/pets', [ApiPetController::class, 'store']);
Route::put('api/pets/{id}', [ApiPetController::class, 'update']);
Route::delete('api/pets/{id}', [ApiPetController::class, 'destroy']);
Route::get('api/pets/{id}', [ApiPetController::class, 'show']);
Route::get('api/categories', [ApiCategoryController::class, 'all']);
Route::get('api/categories/{id}', [ApiCategoryController::class, 'show']);