@extends('layouts.app')

@section('title', 'Issue Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-box-arrow-up-right me-2"></i>Issue Book</h4>
    <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('borrowings.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Book</label>
                    <select name="book_id" class="form-select" required>
                        <option value="">-- Select Book --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->book_id }}" {{ old('book_id') == $book->book_id ? 'selected' : '' }}>{{ $book->title }} ({{ $book->available_copies }} avail)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Member</label>
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Select Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->member_id }}" {{ old('member_id') == $member->member_id ? 'selected' : '' }}>{{ $member->fullName() }} ({{ $member->membership_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Librarian</label>
                    <select name="librarian_id" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($librarians as $librarian)
                            <option value="{{ $librarian->librarian_id }}" {{ old('librarian_id') == $librarian->librarian_id ? 'selected' : '' }}>{{ $librarian->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Loan Days</label>
                    <input type="number" name="loan_days" class="form-control" value="{{ old('loan_days', $defaultLoanDays) }}" min="1" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Issue Book</button>
            </div>
        </form>
    </div>
</div>
@endsection
