<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookIndexRequest;
use App\Http\Resources\BookCollection;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }
    public function search(BookIndexRequest $request): JsonResponse
    {
        $books = $this->bookService->search($request->input('q'), $request->input('page', 1));
        $books =  new BookCollection($books);
        return response()->json($books);
    }
}
