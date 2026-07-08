@extends('layouts.app')

@section('title', 'Borrowing History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-clock-history me-2"></i>Borrowing History — {{ $member->fullName() }}</h4>
    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Book</th><th>Borrowed</th><th>Due</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($history as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->borrow_date->format('d M Y') }}</td>
                        <td>{{ $loan->due_date->format('d M Y') }}</td>
                        <td><span class="badge bg-{{ $loan->status === 'returned' ? 'success' : ($loan->status === 'borrowed' ? 'primary' : 'danger') }}">{{ ucfirst($loan->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No borrowing history.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
