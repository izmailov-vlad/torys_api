<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/books', 'App\Http\Controllers\BooksController@getBooks');

Route::get('/authors', 'App\Http\Controllers\AuthorController@getAuthors');

Route::get('/categories', 'App\Http\Controllers\CategoryController@getCategories');

Route::get('/booksByCategory/{category_id}', 'App\Http\Controllers\CategoryController@getBooksByCategory');

Route::get('/categoriesByBook', 'App\Http\Controllers\BooksController@getCategories');


Route::group(['middleware' => ['auth:sanctum']], function ($route){
    $route->post('logout', [LogoutController::class, 'logout']);

    $route->get('/user', [LoginController::class, 'user']);
});

