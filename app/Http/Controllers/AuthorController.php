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
        $data = Author::all();
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        return response()->json(['authors' => $data], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getBooksByAuthor($authorId): JsonResponse
    {
        $data = Author::with('books')->find($authorId)->books;
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
