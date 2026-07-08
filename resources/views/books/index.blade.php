@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-book me-2"></i>Books</h4>
    <a href="{{ route('books.create') }}" class="btn btn-lms"><i class="bi bi-plus-circle me-1"></i> Add Book</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('books.index') }}" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Search title, author, ISBN" value="{{ $search }}">
                    <button type="submit" class="btn btn-lms">Search</button>
                    @if($search)
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th>Copies</th><th>Status</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category?->name ?? '-' }}</td>
                        <td>{{ $book->available_copies }} / {{ $book->total_copies }}</td>
                        <td><span class="badge bg-{{ $book->status === 'available' ? 'success' : ($book->status === 'archived' ? 'secondary' : 'warning') }}">{{ ucfirst($book->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('books.destroy', $book) }}" class="d-inline" onsubmit="return confirm('Delete this book?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No books found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $books->links() }}</div>
</div>
@endsection
