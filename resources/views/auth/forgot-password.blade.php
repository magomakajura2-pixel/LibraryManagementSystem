@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">
        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center text-white position-relative" style="background: linear-gradient(135deg, var(--lms-dark-green) 0%, var(--lms-green) 100%);">
            <div class="position-relative text-center px-5">
                <i class="bi bi-book-half" style="font-size:6rem;color:var(--lms-gold)"></i>
                <h1 class="display-4 fw-bold mt-4">{{ config('app.name') }}</h1>
                <p class="lead mt-3" style="max-width: 500px;">Manage books, members, and circulation with ease.</p>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-white p-4">
            <div class="w-100" style="max-width: 420px;">
                <div class="text-center mb-4">
                    <i class="bi bi-key" style="font-size:2.5rem;color:var(--lms-dark-green)"></i>
                    <h2 class="mt-2 fw-bold">Reset Password</h2>
                    <p class="text-muted">Enter your registered email and new password.</p>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.reset') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Registered Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lms w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset & Login
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none" style="font-size: 0.9rem; color: var(--lms-green);">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
