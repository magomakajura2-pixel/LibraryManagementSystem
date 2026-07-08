@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">
        <!-- Left side: library intro -->
        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center text-white position-relative" style="background: linear-gradient(135deg, var(--lms-dark-green) 0%, var(--lms-green) 100%);">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><rect fill=%22none%22 width=%22100%25%22 height=%22100%25%22/><pattern id=%22p%22 width=%2240%22 height=%2240%22 patternUnits=%22userSpaceOnUse%22><circle cx=%2220%22 cy=%2220%22 r=%221.5%22 fill=%22rgba(255,255,255,0.08)%22/></pattern><rect fill=%22url%28%23p%29%22 width=%22100%25%22 height=%22100%25%22/></svg>'); opacity: 0.6;"></div>
            <div class="position-relative text-center px-5">
                <i class="bi bi-book-half" style="font-size:6rem;color:var(--lms-gold)"></i>
                <h1 class="display-4 fw-bold mt-4">{{ config('app.name') }}</h1>
                <p class="lead mt-3" style="max-width: 500px;">Manage books, members, and circulation with ease. Your community knowledge hub, now digital.</p>
                <div class="mt-4 d-flex justify-content-center gap-4" style="font-size: 0.95rem; opacity: 0.9;">
                    <span><i class="bi bi-collection me-1"></i> Catalog</span>
                    <span><i class="bi bi-people me-1"></i> Members</span>
                    <span><i class="bi bi-arrow-repeat me-1"></i> Circulation</span>
                </div>
            </div>
        </div>

        <!-- Right side: login form -->
        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-white p-4">
            <div class="w-100" style="max-width: 420px;">
                <div class="text-center mb-4">
                    <i class="bi bi-book" style="font-size:2.5rem;color:var(--lms-dark-green)"></i>
                    <h2 class="mt-2 fw-bold">{{ config('app.name') }}</h2>
                    <p class="text-muted">Sign in to continue</p>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login.authenticate') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" value="{{ old('username') }}" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 0.9rem; color: var(--lms-green);">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-lms w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
