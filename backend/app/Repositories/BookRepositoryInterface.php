<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    /**
     * Get all books
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBooks(): Collection;
    
    /**
     * Get book by ID
     * 
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book;
    
    /**
     * Get book by title
     * 
     * @param string $title
     * @return Book|null
     */
    public function getBookByTitle(string $title): ?Book;
    
    /**
     * Get books by author
     * 
     * @param string $author
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBooksByAuthor(string $author): Collection;
    
    /**
     * Create a new book
     * 
     * @param array $bookData
     * @return Book
     */
    public function createBook(array $bookData): Book;
    
    /**
     * Update an existing book
     * 
     * @param int $id
     * @param array $bookData
     * @return Book|null
     */
    public function updateBook(int $id, array $bookData): ?Book;
    
    /**
     * Delete a book
     * 
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool;
}