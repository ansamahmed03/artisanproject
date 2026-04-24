@extends('frontend.layout.app')

@section('title', 'Register as Artisan')

@section('styles')
<style>
    .auth-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
    .auth-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 460px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .auth-logo { text-align: center; margin-bottom: 1.5rem; }
    .auth-logo span { font-size: 24px; font-weight: 700; color: #2D6A4F; }
    .auth-logo span b { color: #1A1A2E; }
    .auth-title { font-size: 22px; font-weight: 700; text-align: center; margin-bottom: .5rem; }
    .auth-subtitle { font-size: 13px; color: #aaa; text-align: center; margin-bottom: 2rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
    .form-group input,
    .form-group select,
    .form-group textarea { width: 100%; padding: 10px 14px; border: 1px solid #eee; border-radius: 10px; font-size: 14px; outline: none; font-family: inherit; background: #fff; }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color: #2D6A4F; }
    .form-group textarea { resize: vertical; min-height: 80px; }
    .submit-btn { width: 100%; background: #2D6A4F; color: #fff; border: none; padding: 12px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: .5rem; }
    .submit-btn:hover { background: #245c43; }
    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 13px; color: #888; }
    .auth-footer a { color: #2D6A4F; font-weight: 600; text-decoration: none; }
    .back-link { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #888; text-decoration: none; margin-bottom: 1.5rem; }
    .back-link:hover { color: #2D6A4F; }
    .badge-type { display: inline-flex; align-items: center; gap: 6px; background: #E1F5EE; color: #2D6A4F; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 50px; margin: 0 auto 1.5rem; }
    .badge-wrap { text-align: center; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-logo">
            <span>Artisan<b>Hub</b></span>
        </div>

        <div class="badge-wrap">
            <span class="badge-type"><i class="fas fa-tools"></i> Artisan Account</span>
        </div>

        <h2 class="auth-title">Create your account</h2>
        <p class="auth-subtitle">Join as an artisan and showcase your skills</p>

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:10px 14px;margin-bottom:1rem;">
            @foreach($errors->all() as $error)
                <p style="font-size:13px;color:#e74c3c;margin:2px 0;">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('front.register.artisan.post') }}">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="artisan_name" value="{{ old('artisan_name') }}" placeholder="Your full name" required>
            </div>

            <div class="form-group">
                <label>Store Name</label>
                <input type="text" name="store_name" value="{{ old('store_name') }}" placeholder="Your store or brand name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
                <label>City</label>
                <select name="city_id" required>
                    <option value="">-- Select City --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Bio <span style="color:#aaa;font-weight:400;">(optional)</span></label>
                <textarea name="bio" placeholder="Tell us about your craft and skills...">{{ old('bio') }}</textarea>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a strong password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="submit-btn">Create Artisan Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('front.login') }}">Sign in</a>
            &nbsp;·&nbsp; <a href="{{ route('front.register.select') }}">Change type</a>
        </div>

    </div>
</div>
@endsection
