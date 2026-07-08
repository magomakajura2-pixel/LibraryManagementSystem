@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-pencil me-2"></i>Edit Member</h4>
    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('members.update', $member) }}">
            @csrf @method('PUT')
            @include('members._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Update Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
