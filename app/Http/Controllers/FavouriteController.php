<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavouriteController extends Controller
{
    function getFavouriteBooks()
    {

        $currentUserId = Auth::id();
        $data = User::with('favouriteBooks')->get()->find($currentUserId);
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    function addBookToFavourite($bookId)
    {
        $currentUserId = Auth::id();

        $result = DB::table('user_favourite')->insert(['user_id' => $currentUserId, 'books_id' => $bookId]);
        $favourites = User::with('favouriteBooks')->get()->find($currentUserId);
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['success' => $result, 'favourites' => $favourites], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    function removeBookFromFavourite($bookId)
    {
        $isSuccess = false;
        $currentUserId = Auth::id();

        $result = DB::table('user_favourite')->where('books_id', $bookId)->delete();
        if ($result != null) $isSuccess = true;
        $favourites = User::with('favouriteBooks')->get()->find($currentUserId);
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['success' => $isSuccess, 'favourites' => $favourites], 200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
