@extends('layouts.app')

@section('title', 'Active Loans')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-arrow-right-circle me-2"></i>Active Loans</h4>
    <a href="{{ route('borrowings.create') }}" class="btn btn-lms"><i class="bi bi-box-arrow-up-right me-1"></i> Issue Book</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Book</th><th>Member</th><th>Borrowed</th><th>Due</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr class="{{ $loan->status === 'overdue' ? 'table-danger' : '' }}">
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->member->fullName() }}</td>
                        <td>{{ $loan->borrow_date->format('d M Y') }}</td>
                        <td>{{ $loan->due_date->format('d M Y') }}</td>
                        <td><span class="badge bg-{{ $loan->status === 'overdue' ? 'danger' : 'primary' }}">{{ ucfirst($loan->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No active loans.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $loans->links() }}</div>
</div>
@endsection
