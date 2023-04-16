<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_service_search_method_returns_collection_instance(): void
    {
        $books = (new BookService)->search();
        $this->assertInstanceOf(Collection::class, $books);
    }

    public function test_book_service_search_method_returns_data_with_no_parameters(): void
    {
        Book::factory()->count(3)->create();
        $books = (new BookService)->search();
        $this->assertEquals(3, $books->count());
    }

    public function test_book_service_search_method_perform_search_correctly_based_on_title(): void
    {
        $book = Book::factory([
            'title'     => 'Python Data Science Handbook',
            'summary'   => 'This website contains the full text of the Python Data Science Handbook by Jake VanderPlas; the content is available on GitHub in the form of Jupyter notebooks.',
            'publisher' => 'Oreily'
        ])
            ->create();
        DB::commit();
        $books = (new BookService)->search("Python");
        $this->assertTrue($books->contains($book));
        
    }
    public function test_book_service_search_method_perform_search_correctly_based_on_publisher(): void
    {
        $book = Book::factory([
            'title'     => 'Python Data Science Handbook',
            'summary'   => 'This website contains the full text of the Python Data Science Handbook by Jake VanderPlas; the content is available on GitHub in the form of Jupyter notebooks.',
            'publisher' => 'Oreily'
        ])
            ->create();
        DB::commit();
        $books = (new BookService)->search("Oreily");
        $this->assertTrue($books->contains($book));
        
    }
    public function test_book_service_search_method_perform_search_correctly_based_on_summary(): void
    {
        $book = Book::factory([
            'title'     => 'Python Data Science Handbook',
            'summary'   => 'This website contains the full text of the Python Data Science Handbook by Jake VanderPlas; the content is available on GitHub in the form of Jupyter notebooks.',
            'publisher' => 'Oreily'
        ])
            ->create();
        DB::commit();
        $books = (new BookService)->search("VanderPlas");
        $this->assertTrue($books->contains($book));
        
    }

    public function test_book_service_search_method_has_pagination(): void
    {
        Book::factory(['publisher' => 'Oreily'])->count(20)->create();
        DB::commit();
        $searchedBooks = (new BookService)->search('Oreily', $page = 2);
        $this->assertTrue($searchedBooks->isNotEmpty());
        
    }
}
