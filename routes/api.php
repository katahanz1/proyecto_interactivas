<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/books', [ApiController::class, 'getBooks']);
Route::get('/external/book', [ApiController::class, 'fetchBookDetails']);
Route::post('/authors/find-or-create', [ApiController::class, 'findOrCreateAuthor']);
Route::post('/categories/find-or-create', [ApiController::class, 'findOrCreateCategory']);
