<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function getCommentsByUser($id) {
        return User::with('comments')->where('id', $id);
    }
}
