@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h4 class="mb-4 fw-bold"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-green"><i class="bi bi-book"></i></div>
                <div class="ms-3">
                    <div class="stat-value">{{ $stats['total_books'] }}</div>
                    <div class="stat-label">Total Books</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-gold"><i class="bi bi-people"></i></div>
                <div class="ms-3">
                    <div class="stat-value">{{ $stats['total_members'] }}</div>
                    <div class="stat-label">Members</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-teal"><i class="bi bi-arrow-right-circle"></i></div>
                <div class="ms-3">
                    <div class="stat-value">{{ $stats['active_loans'] }}</div>
                    <div class="stat-label">Active Loans</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-danger-soft"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="ms-3">
                    <div class="stat-value">{{ $stats['overdue_loans'] }}</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-lightning me-1"></i> Quick Actions</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('borrowings.create') }}" class="btn btn-lms"><i class="bi bi-box-arrow-up-right me-1"></i> Issue Book</a>
                <a href="{{ route('returns.create') }}" class="btn btn-gold"><i class="bi bi-box-arrow-in-down-left me-1"></i> Return Book</a>
                <a href="{{ route('books.create') }}" class="btn btn-outline-secondary"><i class="bi bi-plus-circle me-1"></i> Add Book</a>
                <a href="{{ route('members.create') }}" class="btn btn-outline-secondary"><i class="bi bi-person-plus me-1"></i> Register Member</a>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body text-center">
                <div class="stat-label mb-1">Unpaid Fines (TZS)</div>
                <div class="stat-value text-danger">{{ number_format($stats['unpaid_fines']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-clock-history me-1"></i> Recent Activity</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:.85rem">
                        <thead class="table-light">
                            <tr><th>Action</th><th>Table</th><th>Details</th><th>Time</th></tr>
                        </thead>
                        <tbody>
                            @forelse($activity as $a)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $a->action }}</span></td>
                                    <td>{{ $a->table_name }}</td>
                                    <td>{{ $a->details }}</td>
                                    <td class="text-muted">{{ $a->created_at->format('d M H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No recent activity.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
