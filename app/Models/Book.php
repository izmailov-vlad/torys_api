<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    public function authors()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function rates()
    {
        return $this->belongsToMany(User::class, 'user_rate', 'user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_book', 'book_id', 'category_id');
    }

    public function getIsFavouriteAttribute()
    {
        if (Auth::check()) {
            return DB::table('user_favourite')
                ->select('books_id', 'user_id')
                ->where('book_id', $this->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
        return false;
    }

}
