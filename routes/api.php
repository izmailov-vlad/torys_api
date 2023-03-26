<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\AuthorController;
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

Route::get('/images/book/{image_book_id}', [BooksController::class, 'getBookById']);


Route::get('/categoriesByBook', 'App\Http\Controllers\BooksController@getCategories');

Route::get('/user/findBook/', [BooksController::class, 'findBook']);

Route::get('/authors', [AuthorController::class, 'getAuthors']);

Route::get('/booksByAuthor/{author_id}', [AuthorController::class, 'getBooksByAuthor']);


Route::group(['middleware' => ['auth:sanctum']], function ($route) {

    Route::get('/booksByCategory/{category_id}', 'App\Http\Controllers\CategoryController@getBooksByCategory');

    Route::get('/bookById/{book_id}', [BooksController::class, 'getBookById']);

    Route::get('/user/check', [LoginController::class, 'checkUser']);

    $route->post('/user/logout', [LogoutController::class, 'logout']);

    Route::post('/user/rateBook/{book_id}/{rate}', [BooksController::class, 'rateBook']);

    Route::get('/user/getAllCommentByBook/{book_id}', [CommentsController::class, 'getAllCommentsByBook']);

    Route::post('/user/likeBook/{book_id}/{comment_id}', [CommentsController::class, 'likeBook']);

    Route::post('/user/dislikeBook/{book_id}/{comment_id}', [CommentsController::class, 'dislikeBook']);

    Route::post('/user/addCommentToBook/{book}', [CommentsController::class, 'addCommentToBook']);

    Route::get('/user/favouriteBooks', [FavouriteController::class, 'getFavouriteBooks']);

    Route::post('/user/addBookToFavourite/{book_id}', [FavouriteController::class, 'addBookToFavourite']);

    Route::post('/user/removeBookFromFavourite/{book_id}', [FavouriteController::class, 'removeBookFromFavourite']);

    $route->get('/user', [LoginController::class, 'user']);
});

