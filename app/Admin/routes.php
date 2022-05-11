<?php

use App\Admin\Controllers\AuthorController;
use App\Admin\Controllers\AuthorsController;
use App\Admin\Controllers\BookController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\CommentsController;
use App\Admin\Controllers\UserController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/authors', AuthorsController::class);
    $router->resource('/comments', CommentsController::class);
    $router->resource('/category', CategoryController::class);
    $router->resource('/books', BookController::class);
    $router->resource('/users', UserController::class);

});
