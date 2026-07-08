@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-plus-circle me-2"></i>Add Book</h4>
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            @include('books._form', ['book' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Save Book</button>
            </div>
        </form>
    </div>
</div>
@endsection
