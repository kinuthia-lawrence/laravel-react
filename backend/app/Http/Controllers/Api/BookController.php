<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\BookNotFoundException;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * @var BookService
     */
    protected $bookService;

    /**
     * BookController constructor
     * 
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the books
     * 
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Book::class);
        $books = $this->bookService->getAllBooks();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created book in storage
     * 
     * @param StoreBookRequest $request
     * @return BookResource
     */
    public function store(StoreBookRequest $request): BookResource
    {
        Gate::authorize('create', Book::class);
        $book = $this->bookService->createBook($request->validated());
        return new BookResource($book);
    }

    /**
     * Display the specified book
     * 
     * @param int $id
     * @return BookResource
     * @throws BookNotFoundException
     */
    public function show(int $id): BookResource
    {
        $book = $this->bookService->getBookById($id);
        Gate::authorize('view', $book);
        return new BookResource($book);
    }

    /**
     * Update the specified book in storage
     * 
     * @param UpdateBookRequest $request
     * @param int $id
     * @return BookResource
     * @throws BookNotFoundException
     */
    public function update(UpdateBookRequest $request, int $id): BookResource
    {
        $book = $this->bookService->getBookById($id);
        Gate::authorize('update', $book);
        $upadateBook = $this->bookService->updateBook($id, $request->validated());
        return new BookResource($upadateBook);
    }

    /**
     * Remove the specified book from storage
     * 
     * @param int $id
     * @return JsonResponse
     * @throws BookNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        $book = $this->bookService->getBookById($id);
        Gate::authorize('delete', $book);
        $this->bookService->deleteBook($id);
        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * Get book by title
     * 
     * @param string $title
     * @return BookResource
     * @throws BookNotFoundException
     */
    public function getByTitle(string $title): BookResource
    {
        $book = $this->bookService->getBookByTitle($title);
        return new BookResource($book);
    }

    /**
     * Get books by author
     * 
     * @param string $author
     * @return AnonymousResourceCollection
     */
    public function getByAuthor(string $author): AnonymousResourceCollection
    {
        $books = $this->bookService->getBooksByAuthor($author);
        return BookResource::collection($books);
    }
}
