<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function getAuthors(): JsonResponse
    {
        $data = Book::with('authors')->get();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        dd($data);
//        return response()->json($data,200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
