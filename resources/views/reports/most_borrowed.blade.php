@extends('layouts.app')

@section('title', 'Most Borrowed Books')

@section('content')
<h4 class="mb-4 fw-bold"><i class="bi bi-bar-chart me-2"></i>Most Borrowed Books</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Title</th><th>Author</th><th>Times Borrowed</th></tr>
            </thead>
            <tbody>
                @forelse($books as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->author }}</td>
                        <td><span class="badge bg-lms">{{ $row->times_borrowed }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
