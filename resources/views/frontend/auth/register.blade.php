@extends('frontend.layout.app')

@section('title', 'Register')

@section('styles')
<style>
    .auth-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
    .auth-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; }
    .auth-logo { text-align: center; margin-bottom: 1.5rem; }
    .auth-logo span { font-size: 24px; font-weight: 700; color: #2D6A4F; }
    .auth-logo span b { color: #1A1A2E; }
    .auth-title { font-size: 22px; font-weight: 700; text-align: center; margin-bottom: .5rem; }
    .auth-subtitle { font-size: 13px; color: #aaa; text-align: center; margin-bottom: 2rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
    .form-group input { width: 100%; padding: 10px 14px; border: 1px solid #eee; border-radius: 10px; font-size: 14px; outline: none; }
    .form-group input:focus { border-color: #2D6A4F; }
    .submit-btn { width: 100%; background: #2D6A4F; color: #fff; border: none; padding: 12px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: .5rem; }
    .submit-btn:hover { background: #245c43; }
    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 13px; color: #888; }
    .auth-footer a { color: #2D6A4F; font-weight: 600; text-decoration: none; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-logo">
            <span>Artisan<b>Hub</b></span>
        </div>

        <h2 class="auth-title">Create account</h2>
        <p class="auth-subtitle">Join ArtisanHub today</p>

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:10px 14px;margin-bottom:1rem;">
            @foreach($errors->all() as $error)
                <p style="font-size:13px;color:#e74c3c;margin:0">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('front.register.post') }}">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm your password">
            </div>

            <button type="submit" class="submit-btn">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('front.login') }}">Sign in</a>
        </div>

    </div>
</div>
@endsection
