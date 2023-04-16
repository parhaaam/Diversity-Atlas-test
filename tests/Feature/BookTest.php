<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_not_perform_search_with_invalid_inputs(): void
    {
        $response = $this->json('GET', route('search.books'), [
            'q'    => 'test',
            'page' => 'test', // invalid data
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => ["page"]
        ]);
    }

    public function test_user_can_perform_search_with_valid_inputs(): void
    {
        Book::factory(['publisher' => 'Oreily'])
            ->has(Author::factory(['name' => 'Vlad']))
            ->count(20)
            ->create();
        DB::commit();

        $response = $this->json('GET', route('search.books'), [
            'q'    => 'Oreily',
            'page' => '1',
        ]);
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function test_search_end_point_return_correct_json_structure(): void
    {
        Book::factory(['publisher' => 'Oreily'])
            ->has(Author::factory(['name' => 'Vlad']))
            ->count(20)
            ->create();
        DB::commit();

        $response = $this->json('GET', route('search.books'), [
            'q'    => 'Oreily',
            'page' => '1',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                "id",
                "publisher",
                "title",
                "summary",
                "authors"
            ]
        ]);
    }

    public function test_user_can_perform_search_with_pagination(): void
    {
        Book::factory(['publisher' => 'Oreily'])
            ->has(Author::factory(['name' => 'Vlad']))
            ->count(20)
            ->create();
        DB::commit();

        $response = $this->json('GET', route('search.books'), [
            'q'    => 'Oreily',
            'page' => '2',
        ]);
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

}
