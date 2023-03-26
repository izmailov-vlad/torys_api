<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use PhpParser\Node\Scalar\String_;
use Ramsey\Collection\Collection;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $data = Category::with('books')->get();
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getBooksByCategory($categoryId)
    {
        $data = Category::with('books')->where('id', $categoryId)->get()->get(0)['books'];
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['books' => $data], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);


    }
}
