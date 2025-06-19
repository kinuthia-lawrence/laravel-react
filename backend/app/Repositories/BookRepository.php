<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    /**
     * Get all books
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBooks(): Collection
    {
        return Book::all();
    }
    
    /**
     * Get book by ID
     * 
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book
    {
        return Book::find($id);
    }
    
    /**
     * Get book by title
     * 
     * @param string $title
     * @return Book|null
     */
    public function getBookByTitle(string $title): ?Book
    {
        return Book::where('title', 'like', "%{$title}%")->first();
    }
    
    /**
     * Get books by author
     * 
     * @param string $author
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBooksByAuthor(string $author): Collection
    {
        return Book::where('author', 'like', "%{$author}%")->get();
    }
    
    /**
     * Create a new book
     * 
     * @param array $bookData
     * @return Book
     */
    public function createBook(array $bookData): Book
    {
        return Book::create($bookData);
    }
    
    /**
     * Update an existing book
     * 
     * @param int $id
     * @param array $bookData
     * @return Book|null
     */
    public function updateBook(int $id, array $bookData): ?Book
    {
        $book = $this->getBookById($id);
        
        if ($book) {
            $book->update($bookData);
            return $book->fresh();
        }
        
        return null;
    }
    
    /**
     * Delete a book
     * 
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool
    {
        $book = $this->getBookById($id);
        
        if ($book) {
            return $book->delete();
        }
        
        return false;
    }
}