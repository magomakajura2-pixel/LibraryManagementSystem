@extends('layouts.app')

@section('title', 'Book Availability')

@section('content')
<h4 class="mb-4 fw-bold"><i class="bi bi-stack me-2"></i>Book Availability</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th>Total</th><th>Available</th><th>On Loan</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($books as $row)
                    <tr>
                        <td>{{ $row->isbn }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->author }}</td>
                        <td>{{ $row->category ?? '-' }}</td>
                        <td>{{ $row->total_copies }}</td>
                        <td>{{ $row->available_copies }}</td>
                        <td>{{ $row->copies_on_loan }}</td>
                        <td><span class="badge bg-{{ $row->status === 'available' ? 'success' : 'warning' }}">{{ ucfirst($row->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
