<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function authors() {
        return $this->belongsTo(Author::class, 'book_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'book_id','id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class,'category_book','book_id','category_id');
    }
}
