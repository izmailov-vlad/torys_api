<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function books() {
        return $this->belongsTo(Book::class, 'comment_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'comment_id', 'id');
    }
}
