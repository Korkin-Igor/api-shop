<?php

use App\Http\Controllers\Api\{
    AuthController,
    OrderController,
    ProductController,
    CartItemController,
    CartController
};
use Illuminate\Support\Facades\Route;

// Гость
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

// Для всех
Route::get('/products', [ProductController::class, 'index']);

// ошибка если неавторизованный пользователь
Route::get('/unauthorized', [AuthController::class, 'unauthorized'])
    ->name('login');

// только для авторизованных
Route::middleware('auth:sanctum')->group(function () {

    // Админ
    // create, update, delete для product

    Route::post('/product', [ProductController::class, 'store']);

    Route::patch('/product/{id}', [ProductController::class, 'update'])
        ->where('id', '[0-9]+');

    Route::delete('/product/{id}', [ProductController::class, 'destroy'])
        ->where('id', '[0-9]+');

    // Пользователь (корзина)

    // добавление
    Route::post('/cart/{product_id}', [CartItemController::class, 'store'])
        ->where('product_id', '[0-9]+');
    // просмотр
    Route::get('/cart', [CartItemController::class, 'index']);
    // удаление товара из корзины
    Route::delete('/cart/{product_id}', [CartItemController::class, 'destroy'])
        ->where('product_id', '[0-9]+');
    // оформление заказа
    Route::post('/order', [CartController::class, 'store']);
    // просмотр заказов
    Route::get('/order', [OrderController::class, 'index']);

    // выход
    Route::get('/logout', [AuthController::class, 'logout']);

});
