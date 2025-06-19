 <?php

use App\Http\Controllers\Api\BookController;
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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Book API Routes
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);
    Route::get('/{id}', [BookController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/{id}', [BookController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/{id}', [BookController::class, 'destroy'])->where('id', '[0-9]+');
    Route::get('/title/{title}', [BookController::class, 'getByTitle']);
    Route::get('/author/{author}', [BookController::class, 'getByAuthor']);
});
