@extends('layouts.app')

@section('title', 'Librarians')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-person-badge me-2"></i>Librarians</h4>
    <a href="{{ route('librarians.create') }}" class="btn btn-lms"><i class="bi bi-plus-circle me-1"></i> Add Librarian</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Emp No</th><th>Name</th><th>Email</th><th>Privilege</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($librarians as $librarian)
                    <tr>
                        <td>{{ $librarian->employee_no }}</td>
                        <td>{{ $librarian->fullName() }}</td>
                        <td>{{ $librarian->email ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($librarian->privilege_level) }}</span></td>
                        <td><span class="badge bg-{{ $librarian->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($librarian->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('librarians.edit', $librarian) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('librarians.destroy', $librarian) }}" class="d-inline" onsubmit="return confirm('Remove this librarian?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No librarians found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $librarians->links() }}</div>
</div>
@endsection
