<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\BooksResource;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BooksController extends Controller
{

    public function getCategories()
    {
        $data = Book::with('categories')->get();
        dd($data);
    }


    public function rateBook($bookId, $rate)
    {
        $currentUserId = Auth::id();

        $ratedBook = DB::table('user_rate')->where('user_id', $currentUserId)->where('books_id', $bookId)->count();
        if ($ratedBook == 0) {
            DB::table('user_rate')->where('user_id', $currentUserId)->where('books_id', $bookId)->insert(['user_id' => $currentUserId, 'books_id' => $bookId, 'rate' => $rate]);
        } else {
            DB::table('user_rate')->where('user_id', $currentUserId)->where('books_id', $bookId)->update(['user_id' => $currentUserId, 'books_id' => $bookId, 'rate' => $rate]);
        }


        $data = Book::with('authors')->with('categories')->get()->find($bookId);
        $rate = DB::table('user_rate')
            ->select('rate')
            ->where('user_id', Auth::id())
            ->where('books_id', $bookId)
            ->first();
        $isFavourite = DB::table('user_favourite')
            ->select('books_id', 'user_id')
            ->get()
            ->firstWhere('books_id', $bookId);
        $usersRate = DB::table('user_rate')
            ->where('books_id', $bookId)
            ->select('rate')->get();
        $comments = Comment::with('user')->where('book_id', $bookId)->get();

        $div = $usersRate->count();

        $one = 0;
        $two = 0;
        $three = 0;
        $four = 0;
        $five = 0;
        $oneCount = $usersRate->where('rate', 1)->count();
        $twoCount = $usersRate->where('rate', 2)->count();
        $threeCount = $usersRate->where('rate', 3)->count();
        $fourCount = $usersRate->where('rate', 4)->count();
        $fiveCount = $usersRate->where('rate', 5)->count();
        if ($div > 0) {
            $one = round($usersRate->where('rate', 1)->count() / $usersRate->count() * 100, 1);
            $two = round($usersRate->where('rate', 2)->count() / $usersRate->count() * 100, 1);
            $three = round($usersRate->where('rate', 3)->count() / $usersRate->count() * 100, 1);
            $four = round($usersRate->where('rate', 4)->count() / $usersRate->count() * 100, 1);
            $five = round($usersRate->where('rate', 5)->count() / $usersRate->count() * 100, 1);
        }

        $usersRates = [$one, $two, $three, $four, $five];
        $usersRatesCount = [$oneCount, $twoCount, $threeCount, $fourCount, $fiveCount];
        $isFavourite = $isFavourite != null;
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['book' => $data, 'is_favourite' => $isFavourite, 'rate' => $rate, 'usersRates' => $usersRates, 'usersRatesCount' => $usersRatesCount, 'comments' => $comments], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getBookById($bookId)
    {
        $book = Book::where('id', $bookId)->firstOrFail();

        $rate = $book->rates()->where('user_id', Auth::id())->first();


        $usersRatesCount = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        foreach ($usersRatesCount as $key => &$value) {
            $value = $book->rates()->where('rate', $key)->count();
        }

        $usersRate = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        foreach ($usersRate as $key => &$value) {
            $value = $usersRate[$key] /  $book->rates()->count() * 100;
        }

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(
            ['book' => $data, 'rate' => $rate, 'usersRates' => $usersRates, 'usersRatesCount' => $usersRatesCount, 'comments' => $comments],
            200, $headers, JSON_UNESCAPED_UNICODE);

        return response()->
        json(new BooksResource($data));
    }

    public function getBooksByCategory($categoryId)
    {
        $data = Book::with('categories')->get()->where('id', $categoryId);
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }


    public function findBook(Request $request)
    {
        Log::info('info' . $request->text);

        $books = Book::all();
        $result = collect([]);
        foreach ($books as $book) {
            $title = $book->title;
            Log::info('object: ' . $title);
            $foundSubString = strpos($title, $request->text);
            if ($foundSubString !== false) {
                $result->add($book);
            }
        }


        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($result, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getBooks()
    {
        // use get instead all
        $data = Book::all();

        //add map data $data (laravel resource)
        getBookById();

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
