<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getBooks()
    {
        $books = Book::with(['author', 'category'])->get();
        return response()->json($books);
    }

    public function fetchBookDetails(Request $request)
    {
        $isbn = $request->query('isbn');
        if (!$isbn) {
            return response()->json(['error' => 'El ISBN es obligatorio'], 400);
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->get("https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}");

            if ($response->successful() && $response['totalItems'] > 0) {
                $book = $response['items'][0]['volumeInfo'];
                return response()->json([
                    'title' => $book['title'] ?? '',
                    'author' => $book['authors'][0] ?? '',
                    'category' => $book['categories'][0] ?? '',
                    'published_year' => substr($book['publishedDate'] ?? '', 0, 4),
                    'description' => $book['description'] ?? '',
                ]);
            }

            return response()->json(['error' => 'Libro no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error del servidor: ' . $e->getMessage()], 500);
        }
    }
    public function findOrCreateAuthor(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return response()->json(['error' => 'El nombre es obligatorio'], 400);
        }

        $author = \App\Models\Author::firstOrCreate(['name' => $name]);
        return response()->json($author);
    }

    public function findOrCreateCategory(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return response()->json(['error' => 'El nombre es obligatorio'], 400);
        }

        $category = \App\Models\Category::firstOrCreate(['name' => $name]);
        return response()->json($category);
    }
}
