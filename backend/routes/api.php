 <?php

use App\Http\Controllers\Api\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// routes/api.php
Route::get('/test', function () {
    return response()->json(['message' => 'Hello from API']);
});
Route::get('/test-service',[TestController::class,"index"]);
