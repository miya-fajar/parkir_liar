<?php

use App\Http\Controllers\DataController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/token", function (Request $request) {
    try {
        $user = User::find(1);

        $token = $user->createToken("create-data");

        return ['token' => $token->plainTextToken];
    } catch (Exception $err) {
        return ['error' => $err->getMessage()];
    }
});

Route::post("/user", function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
    ]);

    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt("12345");
    $user->save();

    return [
        'message' => 'User created successfully',
        'user' => $user,
    ];
})->middleware('auth:sanctum');

Route::post("data", [DataController::class, "create"])->middleware('auth:sanctum');
