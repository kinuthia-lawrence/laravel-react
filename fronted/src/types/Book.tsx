export interface Book {
  id: number;
  title: string;
  author: string;
  description?: string;
  image_url?: string;
  book_url?: string;
  publisher?: string;
  publication_year?: number;
  isbn?: string;
  genre?: string;
  status?: 'available' | 'out_of_stock' | 'coming_soon';
  pages?: number;
  price?: number;
  created_at: string;
  updated_at: string;
}

export interface BookFormData {
  title: string;
  author: string;
  description?: string;
  image_url?: string;
  book_url?: string;
  publisher?: string;
  publication_year?: number;
  isbn?: string;
  genre?: string;
  status?: string;
  pages?: number;
  price?: number;
}