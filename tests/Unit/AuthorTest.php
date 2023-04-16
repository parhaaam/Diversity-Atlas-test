<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_author_belongs_to_many_books(): void
    {
        $author        = Author::factory()->has(Book::factory())->create();
        $booksRelation = $author->books();
        $this->assertInstanceOf(BelongsToMany::class, $booksRelation);
    }
}
