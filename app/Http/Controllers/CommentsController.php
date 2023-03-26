<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function getCommentsByUser($id)
    {
        return User::with('comments')->where('id', $id);
    }

    public function getAllCommentsByBook($bookId)
    {
        $data = Comment::with('user')->where('book_id', $bookId)->get();
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['comments' => $data], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function likeBook($bookId, $commentId)
    {
        $comment = Comment::all()->find($commentId);
        $comment->likes += 1;
        $comment->save();

        $data = Comment::with('user')->where('book_id', $bookId)->get();
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['comments' => $data], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function dislikeBook($bookId, $commentId)
    {
        $comment = Comment::all()->find($commentId);
        $comment->dislikes += 1;
        $comment->save();

        $data = Comment::with('user')->where('book_id', $bookId)->get();

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['comments' => $data], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function addCommentToBook(StoreCommentRequest $request, Book $book)
    {
        $book->comment()->create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'likes' => 0,
            'dislikes' => 0
        ]);

        return response()->json(['comments' => $book->comments]);
    }
}
