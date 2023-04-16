<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_has_many_books(): void
    {
        $author = Author::factory()->create();
        $books  = Book::factory()->count(2)->create();
        $author->books()->sync($books);

        $this->assertCount(2, $author->books);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $author->books);
        $this->assertInstanceOf(\App\Models\Book::class, $author->books->random());
    }

    public function test_author_books_returns_belong_to_many(): void
    {
        $author = Author::factory()->make();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $author->books());
    }

}
