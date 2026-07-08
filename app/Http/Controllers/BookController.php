<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('q', ''));
        $books = Book::with('category')
            ->when($search, fn ($q) => $q->search($search))
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('books.index', compact('books', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,category_id',
            'publisher' => 'nullable|string|max:150',
            'published_year' => 'nullable|integer',
            'shelf_location' => 'nullable|string|max:50',
            'total_copies' => 'required|integer|min:1',
        ]);

        $validated['available_copies'] = $validated['total_copies'];
        $validated['status'] = 'available';

        $book = Book::create($validated);

        AuditLog::create([
            'actor' => auth()->user()->username ?? 'system',
            'action' => 'INSERT',
            'table_name' => 'books',
            'record_id' => $book->book_id,
            'details' => 'Added: ' . $book->title,
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->book_id . ',book_id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,category_id',
            'publisher' => 'nullable|string|max:150',
            'published_year' => 'nullable|integer',
            'shelf_location' => 'nullable|string|max:50',
            'total_copies' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable,archived',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->available_copies !== $book->total_copies) {
            return redirect()->route('books.index')->with('error', 'Cannot delete — book has copies on loan.');
        }

        AuditLog::create([
            'actor' => auth()->user()->username ?? 'system',
            'action' => 'DELETE',
            'table_name' => 'books',
            'record_id' => $book->book_id,
            'details' => 'Deleted: ' . $book->title,
        ]);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}
