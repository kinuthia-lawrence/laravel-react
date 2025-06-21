import API from './api';
import type { Book, BookFormData } from '../types/Book';

const BookService = {
  async getAllBooks() {
    const response = await API.get('/books');
    return response.data;
  },

  async getBookById(id: number) {
    const response = await API.get(`/books/${id}`);
    return response.data;
  },

  async getBooksByTitle(title: string) {
    const response = await API.get(`/books/title/${title}`);
    return response.data;
  },

  async getBooksByAuthor(author: string) {
    const response = await API.get(`/books/author/${author}`);
    return response.data;
  },

  async createBook(bookData: BookFormData) {
    const response = await API.post('/books', bookData);
    return response.data;
  },

  async updateBook(id: number, bookData: BookFormData) {
    const response = await API.put(`/books/${id}`, bookData);
    return response.data;
  },

  async deleteBook(id: number) {
    const response = await API.delete(`/books/${id}`);
    return response.data;
  }
};

export default BookService;