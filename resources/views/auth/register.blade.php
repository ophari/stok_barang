@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg p-4 rounded-4 w-100" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="text-center mb-3">Register</h3>

            <!-- Flash Message -->
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Name -->
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="col-md-12 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-12 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </div>

                    <!-- Login Link -->
                    <div class="col-md-12 text-center mt-3">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
