<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_has_many_authors(): void
    {
        $book    = Book::factory()->create();
        $authors = Author::factory()->count(2)->create();
        $book->authors()->sync($authors);

        $this->assertCount(2, $book->authors);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $book->authors);
        $this->assertInstanceOf(\App\Models\Author::class, $book->authors->random());
    }

    public function test_books_authors_returns_belong_to_many(): void
    {
        $book = Book::factory()->make();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $book->authors());
    }

    public function test_search_by_scope_filters_records_using_key_by_full_text_search()
    {
        Book::factory([
            'title'     => 'Python Data Science Handabook',
            'summary'   => 'This website contains the full text of the Python Data Science Handbook by Jake VanderPlas; the content is available on GitHub in the form of Jupyter notebooks.',
            'publisher' => 'Oreily'
        ])
            ->create();
        DB::commit();
        
        $booksFiteredByTitle     = Book::SearchBy("Python", 'title');
        $booksFiteredBySummary   = Book::SearchBy("VanderPlas", 'summary');
        $booksFiteredByPublisher = Book::SearchBy("Oreily", 'publisher');
        $this->assertGreaterThan(1,$booksFiteredByTitle->count());
        $this->assertGreaterThan(1,$booksFiteredBySummary->count());
        $this->assertGreaterThan(1,$booksFiteredByPublisher->count());
    }

    public function test_search_by_author_scope_filters_records_using_author_name_search()
    {
        $book  = Book::factory([
            'title'     => 'Python Data Science Handbook',
            'summary'   => 'This website contains the full text of the Python Data Science Handbook by Jake VanderPlas; the content is available on GitHub in the form of Jupyter notebooks.',
            'publisher' => 'Oreily'
        ])
            ->create();
        DB::commit();
        $author = Author::factory(['name' => 'Jake VanderPlas'])->create();
        $book->authors()->sync($author);

        $booksFiteredByAuthor = Book::SearchByAuthor("Jake VanderPlas");
        $this->assertEquals($booksFiteredByAuthor->count(), 1);
    }
}
