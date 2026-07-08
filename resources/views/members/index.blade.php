@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-people me-2"></i>Members</h4>
    <a href="{{ route('members.create') }}" class="btn btn-lms"><i class="bi bi-person-plus me-1"></i> Add Member</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>No</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>{{ $member->membership_no }}</td>
                        <td>{{ $member->fullName() }}</td>
                        <td>{{ $member->email ?? '-' }}</td>
                        <td>{{ $member->phone ?? '-' }}</td>
                        <td><span class="badge bg-{{ $member->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($member->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('members.history', $member) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-clock-history"></i></a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('members.destroy', $member) }}" class="d-inline" onsubmit="return confirm('Remove this member?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $members->links() }}</div>
</div>
@endsection
