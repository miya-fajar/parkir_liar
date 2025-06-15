<?php

use App\Http\Controllers\PelanggaranController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get("/token", function (Request $request) {
    try {
        $user = User::find(1);

        $token = $user->createToken("create-data");

        return ['token' => $token->plainTextToken];
    } catch (Exception $err) {
        return ['error' => $err->getMessage()];
    }
});

Route::post("data", [PelanggaranController::class, "create"])->middleware('auth:sanctum');
