<?php

    use App\Http\Controllers\CommentController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    // Маршрут основной страницы
    Route::get('/', [HomeController::class, 'index']);

    // Маршрут для работы с комментариями
    // параметры: add - добавление комментария
    //            more - получение очередной порции комментариев (по условию 3 записи)
    Route::post('/comment/{target}', [CommentController::class, 'main']);

    // Маршрут для работы с пользователями
    // параметры: register, login, logout
    Route::post('/user/{target}', [UserController::class, 'main']);

    Route::fallback(function() {
        abort(404, 'Страница не найдена...');
    });

