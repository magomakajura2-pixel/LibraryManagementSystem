@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-pencil me-2"></i>Edit Book</h4>
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf @method('PUT')
            @include('books._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Update Book</button>
            </div>
        </form>
    </div>
</div>
@endsection
