import React, { useState, useEffect } from 'react';
import BookService from '../services/BookService';
import type { Book, BookFormData } from '../types/Book';
import { useNavigate } from 'react-router-dom';
import AuthService from '../services/authService';

const Home: React.FC = () => {
  const navigate = useNavigate();
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [searchType, setSearchType] = useState<'title' | 'author'>('title');
  
  // New book form state
  const [newBook, setNewBook] = useState<BookFormData>({
    title: '',
    author: '',
    description: '',
    publisher: '',
    publication_year: undefined,
    genre: '',
  });
  
  // Edit book state
  const [editingBook, setEditingBook] = useState<Book | null>(null);
  const [showEditModal, setShowEditModal] = useState(false);
  
  // Form for editing
  const [editForm, setEditForm] = useState<BookFormData>({
    title: '',
    author: '',
    description: '',
    publisher: '',
    publication_year: undefined,
    genre: '',
  });

  // Check if user is authenticated
  useEffect(() => {
    if (!AuthService.isAuthenticated()) {
      navigate('/login');
    }
  }, [navigate]);
  
  // Fetch books on component mount
  useEffect(() => {
    fetchBooks();
  }, []);
  
  const fetchBooks = async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await BookService.getAllBooks();
      setBooks(response.data);
    } catch (err: any) {
      setError('Failed to load books. Please try again later.');
      if (err.response?.status === 401) {
        navigate('/login');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = async () => {
    if (!searchTerm.trim()) {
      fetchBooks();
      return;
    }
    
    setLoading(true);
    try {
      let response;
      if (searchType === 'title') {
        response = await BookService.getBooksByTitle(searchTerm);
        // The API may return a single book or an array
        setBooks(Array.isArray(response.data) ? response.data : [response.data]);
      } else {
        response = await BookService.getBooksByAuthor(searchTerm);
        setBooks(response.data);
      }
    } catch (err) {
      console.log(err);
      setError('No books found with the given search criteria.');
      setBooks([]);
    } finally {
      setLoading(false);
    }
  };
  
  const handleNewBookChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setNewBook({
      ...newBook,
      [name]: value
    });
  };
  
  const handleNewBookSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await BookService.createBook(newBook);
      setNewBook({
        title: '',
        author: '',
        description: '',
        publisher: '',
        publication_year: undefined,
        genre: '',
      });
      fetchBooks(); // Refresh the book list
    } catch (err: any) {
      setError(err.response?.data?.message || 'Failed to create book.');
    }
  };
  
  const openEditModal = (book: Book) => {
    setEditingBook(book);
    setEditForm({
      title: book.title,
      author: book.author,
      description: book.description || '',
      publisher: book.publisher || '',
      publication_year: book.publication_year,
      genre: book.genre || '',
    });
    setShowEditModal(true);
  };
  
  const handleEditChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setEditForm({
      ...editForm,
      [name]: value
    });
  };
  
  const handleEditSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingBook) return;
    
    try {
      await BookService.updateBook(editingBook.id, editForm);
      setShowEditModal(false);
      fetchBooks(); // Refresh the book list
    } catch (err: any) {
      setError(err.response?.data?.message || 'Failed to update book.');
    }
  };
  
  const handleDeleteBook = async (id: number) => {
    if (window.confirm('Are you sure you want to delete this book?')) {
      try {
        await BookService.deleteBook(id);
        fetchBooks(); // Refresh the book list
      } catch (err: any) {
        setError(err.response?.data?.message || 'Failed to delete book.');
      }
    }
  };

  return (
    <div className="container mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold mb-8">Book Management</h1>
      
      {/* Error display */}
      {error && (
        <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <span className="block sm:inline">{error}</span>
        </div>
      )}
      
      {/* Add new book form */}
      <div className="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 className="text-xl font-semibold mb-4">Add New Book</h2>
        <form onSubmit={handleNewBookSubmit}>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Title</label>
              <input 
                type="text"
                name="title"
                value={newBook.title}
                onChange={handleNewBookChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Author</label>
              <input 
                type="text"
                name="author"
                value={newBook.author}
                onChange={handleNewBookChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div className="md:col-span-2">
              <label className="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea 
                name="description"
                value={newBook.description}
                onChange={handleNewBookChange}
                rows={3}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
              <input 
                type="text"
                name="publisher"
                value={newBook.publisher}
                onChange={handleNewBookChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Publication Year</label>
              <input 
                type="number"
                name="publication_year"
                value={newBook.publication_year || ''}
                onChange={handleNewBookChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Genre</label>
              <input 
                type="text"
                name="genre"
                value={newBook.genre}
                onChange={handleNewBookChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div className="md:col-span-2 mt-4">
              <button
                type="submit"
                className="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Add Book
              </button>
            </div>
          </div>
        </form>
      </div>
      
      {/* Search and filter */}
      <div className="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 className="text-xl font-semibold mb-4">Search Books</h2>
        <div className="flex flex-col md:flex-row gap-4">
          <div className="flex-1">
            <input
              type="text"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              placeholder="Search for books..."
              className="w-full px-3 py-2 border border-gray-300 rounded-md"
            />
          </div>
          <div>
            <select
              value={searchType}
              onChange={(e) => setSearchType(e.target.value as 'title' | 'author')}
              className="w-full px-3 py-2 border border-gray-300 rounded-md"
            >
              <option value="title">By Title</option>
              <option value="author">By Author</option>
            </select>
          </div>
          <button 
            onClick={handleSearch}
            className="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
          >
            Search
          </button>
          <button 
            onClick={fetchBooks}
            className="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400"
          >
            Reset
          </button>
        </div>
      </div>
      
      {/* Books display */}
      <div>
        <h2 className="text-2xl font-semibold mb-4">Books</h2>
        
        {loading ? (
          <div className="flex items-center justify-center p-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
          </div>
        ) : books.length === 0 ? (
          <p className="text-center text-gray-500 py-8">No books found.</p>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {books.map(book => (
              <div key={book.id} className="bg-white rounded-lg shadow-md overflow-hidden">
                {book.image_url && (
                  <img src={book.image_url} alt={book.title} className="w-full h-48 object-cover" />
                )}
                <div className="p-6">
                  <h3 className="text-xl font-semibold mb-2">{book.title}</h3>
                  <p className="text-gray-600 mb-2">By {book.author}</p>
                  {book.publisher && <p className="text-gray-500 text-sm">Publisher: {book.publisher}</p>}
                  {book.publication_year && <p className="text-gray-500 text-sm">Year: {book.publication_year}</p>}
                  {book.description && (
                    <p className="text-gray-700 mt-3 line-clamp-3">{book.description}</p>
                  )}
                  <div className="mt-4 flex justify-end space-x-2">
                    <button
                      onClick={() => openEditModal(book)}
                      className="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                      Edit
                    </button>
                    <button
                      onClick={() => handleDeleteBook(book.id)}
                      className="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
      
      {/* Edit Modal */}
      {showEditModal && editingBook && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
          <div className="relative bg-white rounded-lg shadow-xl max-w-md mx-auto p-6 w-full">
            <h3 className="text-xl font-semibold mb-4">Edit Book</h3>
            <form onSubmit={handleEditSubmit}>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Title</label>
                  <input 
                    type="text"
                    name="title"
                    value={editForm.title}
                    onChange={handleEditChange}
                    required
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Author</label>
                  <input 
                    type="text"
                    name="author"
                    value={editForm.author}
                    onChange={handleEditChange}
                    required
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Description</label>
                  <textarea 
                    name="description"
                    value={editForm.description}
                    onChange={handleEditChange}
                    rows={3}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                  <input 
                    type="text"
                    name="publisher"
                    value={editForm.publisher}
                    onChange={handleEditChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Publication Year</label>
                  <input 
                    type="number"
                    name="publication_year"
                    value={editForm.publication_year || ''}
                    onChange={handleEditChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                  <input 
                    type="text"
                    name="genre"
                    value={editForm.genre}
                    onChange={handleEditChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                  />
                </div>
                <div className="flex justify-end space-x-3 pt-4">
                  <button
                    type="button"
                    onClick={() => setShowEditModal(false)}
                    className="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                  >
                    Save Changes
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Home;