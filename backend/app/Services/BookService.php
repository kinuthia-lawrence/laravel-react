<?php

namespace App\Services;

use App\Exceptions\BookNotFoundException;
use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    /**
     * @var BookRepositoryInterface
     */
    protected $bookRepository;
    
    /**
     * BookService constructor
     * 
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    /**
     * Get all books
     * 
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        return $this->bookRepository->getAllBooks();
    }
    
    /**
     * Get book by ID
     * 
     * @param int $id
     * @return Book
     * @throws BookNotFoundException
     */
    public function getBookById(int $id): Book
    {
        $book = $this->bookRepository->getBookById($id);
        
        if (!$book) {
            throw new BookNotFoundException("Book with ID {$id} not found");
        }
        
        return $book;
    }
    
    /**
     * Get book by title
     * 
     * @param string $title
     * @return Book
     * @throws BookNotFoundException
     */
    public function getBookByTitle(string $title): Book
    {
        $book = $this->bookRepository->getBookByTitle($title);
        
        if (!$book) {
            throw new BookNotFoundException("Book with title '{$title}' not found");
        }
        
        return $book;
    }
    
    /**
     * Get books by author
     * 
     * @param string $author
     * @return Collection
     */
    public function getBooksByAuthor(string $author): Collection
    {
        return $this->bookRepository->getBooksByAuthor($author);
    }
    
    /**
     * Create a new book
     * 
     * @param array $bookData
     * @return Book
     */
    public function createBook(array $bookData): Book
    {
        return $this->bookRepository->createBook($bookData);
    }
    
    /**
     * Update an existing book
     * 
     * @param int $id
     * @param array $bookData
     * @return Book
     * @throws BookNotFoundException
     */
    public function updateBook(int $id, array $bookData): Book
    {
        $book = $this->bookRepository->updateBook($id, $bookData);
        
        if (!$book) {
            throw new BookNotFoundException("Book with ID {$id} not found");
        }
        
        return $book;
    }
    
    /**
     * Delete a book
     * 
     * @param int $id
     * @return bool
     * @throws BookNotFoundException
     */
    public function deleteBook(int $id): bool
    {
        $result = $this->bookRepository->deleteBook($id);
        
        if (!$result) {
            throw new BookNotFoundException("Book with ID {$id} not found");
        }
        
        return true;
    }
}