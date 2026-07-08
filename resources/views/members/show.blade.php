@extends('layouts.app')

@section('title', 'Member Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-person me-2"></i>Member Profile</h4>
    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Details</div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $member->fullName() }}</p>
                <p><strong>Membership No:</strong> {{ $member->membership_no }}</p>
                <p><strong>Email:</strong> {{ $member->email ?? '-' }}</p>
                <p><strong>Phone:</strong> {{ $member->phone ?? '-' }}</p>
                <p><strong>Status:</strong> <span class="badge bg-{{ $member->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($member->status) }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Summary</div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-4">
                        <div class="stat-value">{{ $summary?->total_borrowings ?? 0 }}</div>
                        <div class="stat-label">Total Borrowings</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value">{{ $summary?->active_loans ?? 0 }}</div>
                        <div class="stat-label">Active Loans</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value text-danger">{{ number_format($summary?->outstanding_fines ?? 0) }}</div>
                        <div class="stat-label">Outstanding Fines</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
