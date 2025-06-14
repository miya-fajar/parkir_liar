<?php

use App\Http\Controllers\PelanggaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/pelanggaran', [PelanggaranController::class, 'store']);

Route::post('/test-api', function() {
    return response()->json(['message' => 'test ok']);
});
