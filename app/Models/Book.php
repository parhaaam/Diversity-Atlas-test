<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function scopeSearchBy(Builder $query, string $param = null, string $column): void
    {
        $query->when(!is_null($param), fn ($query) => $query->whereFullText($column, $param));
    }

    public function scopeSearchByAuthor(Builder $query, string $name = null): void
    {
        $query
            ->select('books.*')
            ->when(!is_null($name), function ($query) use ($name) {
                $query
                    ->join('author_book', 'books.id', 'book_id')
                    ->join(
                        'authors',
                        function ($join)  use ($name) {
                            $join->on('authors.id', 'author_id')
                                ->whereFullText('authors.name', $name);
                        }
                    );
            });
    }
}
