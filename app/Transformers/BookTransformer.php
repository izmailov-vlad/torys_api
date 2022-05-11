<?php

namespace App\Transformers;

use App\Models\Book;

class BookTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Book $book)
    {
        return [
            'title' => $book->title,
            'image' => $book->image,
        ];
    }
}
