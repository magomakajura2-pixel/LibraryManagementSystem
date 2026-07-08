@extends('layouts.app')

@section('title', 'Edit Librarian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-pencil me-2"></i>Edit Librarian</h4>
    <a href="{{ route('librarians.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('librarians.update', $librarian) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Employee No</label>
                    <input type="text" name="employee_no" class="form-control" value="{{ old('employee_no', $librarian->employee_no) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $librarian->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $librarian->last_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $librarian->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $librarian->phone) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Privilege</label>
                    <select name="privilege_level" class="form-select" required>
                        <option value="librarian" {{ old('privilege_level', $librarian->privilege_level) == 'librarian' ? 'selected' : '' }}>Librarian</option>
                        <option value="assistant" {{ old('privilege_level', $librarian->privilege_level) == 'assistant' ? 'selected' : '' }}>Assistant</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $librarian->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $librarian->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-lms">Update Librarian</button>
            </div>
        </form>
    </div>
</div>
@endsection
