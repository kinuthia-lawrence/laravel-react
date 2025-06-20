 <?php

    use App\Http\Controllers\Api\BookController;
    use App\Http\Controllers\Api\AuthController;
    use Illuminate\Support\Facades\Route;


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
    //Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        // User routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);


        // Book API Routes
        // Public read-only book routes
        Route::prefix('books')->group(function () {
            Route::get('/', [BookController::class, 'index']);
            Route::get('/{id}', [BookController::class, 'show'])->where('id', '[0-9]+');
            Route::get('/title/{title}', [BookController::class, 'getByTitle']);
            Route::get('/author/{author}', [BookController::class, 'getByAuthor']);
        });

        // Routes for editors and admins
        Route::middleware('role:editor')->prefix('books')->group(function () {
            Route::post('/', [BookController::class, 'store']);
            Route::put('/{id}', [BookController::class, 'update'])->where('id', '[0-9]+');
        });

        // Routes only for admins
        Route::middleware('role:admin')->prefix('books')->group(function () {
            Route::delete('/{id}', [BookController::class, 'destroy'])->where('id', '[0-9]+');
        });
    });
