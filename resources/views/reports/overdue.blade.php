@extends('layouts.app')

@section('title', 'Overdue Books')

@section('content')
<h4 class="mb-4 fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Overdue Books</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Book</th><th>Member</th><th>Borrowed</th><th>Due</th><th>Days Overdue</th></tr>
            </thead>
            <tbody>
                @forelse($books as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->member_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->borrow_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->due_date)->format('d M Y') }}</td>
                        <td><span class="badge bg-danger">{{ $row->days_overdue }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No overdue books.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
