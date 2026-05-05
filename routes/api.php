<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\UserController;

// method; path or endpoints
Route::get("/sample", function () {
    // format ng data; data structure
    return response()->json([
        "message" => "This is a sample API endpoint.",
        "token" => "xxxxx",
        "user" => [
            "name" => "Juan",
            "age" => 19
        ]
    ]);
});

Route::post("/login", [AuthController::class, "login"]);
Route::get("/home", [UserController::class,"index"]);
Route::get("/new-record", [UserController::class,"store"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('plants/all', [PlantController::class, 'all']);
    Route::apiResource('plants', PlantController::class);
    Route::apiResource('users', UserController::class);
});