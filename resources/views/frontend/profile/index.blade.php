@extends('frontend.layout.app')

@section('title', 'My Profile')

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }
    .profile-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }

    /* Sidebar */
    .profile-sidebar { }
    .profile-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; text-align: center; margin-bottom: 1rem; }
    .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: #2D6A4F; margin: 0 auto 1rem; }
    .profile-name { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
    .profile-email { font-size: 13px; color: #aaa; margin-bottom: 1rem; }
    .profile-badge { display: inline-block; background: #E1F5EE; color: #0F6E56; font-size: 11px; padding: 4px 12px; border-radius: 50px; }

    .profile-nav { background: #fff; border: 1px solid #eee; border-radius: 16px; overflow: hidden; }
    .profile-nav a { display: flex; align-items: center; gap: 10px; padding: .875rem 1.25rem; font-size: 14px; color: #555; text-decoration: none; border-bottom: 1px solid #eee; }
    .profile-nav a:last-child { border-bottom: none; }
    .profile-nav a:hover { background: #F8F6F2; color: #2D6A4F; }
    .profile-nav a.active { background: #E1F5EE; color: #2D6A4F; font-weight: 600; }
    .profile-nav i { width: 18px; color: #2D6A4F; }

    /* Content */
    .profile-content { }
    .content-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; }
    .content-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .info-item label { display: block; font-size: 12px; color: #aaa; margin-bottom: 4px; }
    .info-item p { font-size: 14px; font-weight: 500; color: #1A1A2E; }

    .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .stat-box { background: #F8F6F2; border-radius: 12px; padding: 1rem; text-align: center; }
    .stat-num { font-size: 24px; font-weight: 700; color: #2D6A4F; }
    .stat-label { font-size: 12px; color: #aaa; margin-top: 4px; }

    .empty-state { text-align: center; padding: 2rem; color: #aaa; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: .75rem; }
    .empty-state p { font-size: 13px; }
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="profile-grid">

        {{-- Sidebar --}}
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div class="profile-name">{{ $customer->name }}</div>
                <div class="profile-email">{{ $customer->email }}</div>
                <span class="profile-badge">Customer</span>
            </div>

            <div class="profile-nav">
                <a href="{{ route('front.profile') }}" class="active">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="#">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="#">
                    <i class="fas fa-calendar"></i> My Bookings
                </a>
                <a href="{{ route('front.wishlist') }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="profile-content">

            {{-- Stats --}}
            <div class="content-card">
                <div class="stat-grid">
                    <div class="stat-box">
                        <div class="stat-num">{{ $customer->orders->count() ?? 0 }}</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num">{{ $customer->bookings->count() ?? 0 }}</div>
                        <div class="stat-label">Bookings</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num">{{ $customer->wishlists->count() ?? 0 }}</div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="content-card">
                <div class="content-title">Personal Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <p>{{ $customer->name }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p>{{ $customer->email }}</p>
                    </div>
                    <div class="info-item">
                        <label>Member Since</label>
                        <p>{{ $customer->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
