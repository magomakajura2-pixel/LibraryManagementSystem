@extends('layouts.app')

@section('title', 'Return Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-box-arrow-in-down-left me-2"></i>Return Book</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('returns.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Active Loan</label>
                    <select name="borrowing_id" class="form-select" required>
                        <option value="">-- Select Loan --</option>
                        @foreach($loans as $loan)
                            <option value="{{ $loan->borrowing_id }}" {{ old('borrowing_id') == $loan->borrowing_id ? 'selected' : '' }}>
                                #{{ $loan->borrowing_id }} — {{ $loan->book->title }} — {{ $loan->member->fullName() }} (due {{ $loan->due_date->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Condition</label>
                    <select name="book_condition" class="form-select" required>
                        <option value="good" {{ old('book_condition') == 'good' ? 'selected' : '' }}>Good</option>
                        <option value="damaged" {{ old('book_condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="lost" {{ old('book_condition') == 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Received By</label>
                    <select name="received_by" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($librarians as $librarian)
                            <option value="{{ $librarian->librarian_id }}" {{ old('received_by') == $librarian->librarian_id ? 'selected' : '' }}>{{ $librarian->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-gold">Record Return</button>
            </div>
        </form>
    </div>
</div>
@endsection
