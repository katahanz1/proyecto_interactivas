<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['author', 'category'])->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $imagePath;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Libro creado exitosamente.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $imagePath;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Display the book catalog for students.
     */
    public function catalog()
    {
        $books = Book::with(['author', 'category'])->get();
        return view('books.catalog', compact('books'));
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Libro eliminado exitosamente.');
    }
}
