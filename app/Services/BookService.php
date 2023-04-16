<?php

namespace App\Services;


use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function search(string $queryTerm = null, int $page = 1): Collection
    {

        $limit                   = 10;
        $offset                  = ($page - 1) * $limit;
        $booksFilteredByAuthor   = Book::SearchByAuthor($queryTerm);
        $booksFiteredByTitle     = Book::SearchBy($queryTerm, 'title');
        $booksFiteredBySummary   = Book::SearchBy($queryTerm, 'summary');
        $booksFiteredByPublisher = Book::SearchBy($queryTerm, 'publisher');
        $unionsOfFilters         = $booksFilteredByAuthor
            ->union($booksFiteredByPublisher)
            ->union($booksFiteredBySummary)
            ->union($booksFiteredByTitle)
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->load('authors');
        return $unionsOfFilters;
    }
}
