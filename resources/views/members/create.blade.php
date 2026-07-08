@extends('layouts.app')

@section('title', 'Add Member')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-person-plus me-2"></i>Add Member</h4>
    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('members.store') }}">
            @csrf
            @include('members._form', ['member' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Register Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
