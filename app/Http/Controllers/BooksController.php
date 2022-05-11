<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Transformers\BookTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use phpDocumentor\Reflection\Types\Collection;


class BooksController extends Controller
{

    public function getCategories() {
        $data = Book::with('categories')->get();
        dd($data);
    }

    public function getBooksByCategory($categoryId) {
        $data = Book::with('categories')->get()->where('id', $categoryId);
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($data,200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getBooks()
    {
        $data = Book::all();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($data,200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
