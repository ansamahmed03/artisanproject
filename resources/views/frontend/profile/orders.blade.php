@extends('frontend.layout.app')

@section('title', 'My Orders')

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }
    .profile-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }

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

    .content-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; }
    .content-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }

    /* Order Card */
    .order-card { border: 1px solid #eee; border-radius: 12px; margin-bottom: 1rem; overflow: hidden; }
    .order-header { display: flex; justify-content: space-between; align-items: center; padding: .875rem 1.25rem; background: #F8F6F2; }
    .order-header-left { display: flex; gap: 2rem; }
    .order-meta label { font-size: 11px; color: #aaa; display: block; margin-bottom: 2px; }
    .order-meta p { font-size: 13px; font-weight: 600; color: #1A1A2E; }
    .order-body { padding: 1rem 1.25rem; }

    /* Order Items */
    .order-item { display: flex; align-items: center; gap: 1rem; padding: .6rem 0; border-bottom: 1px solid #f5f5f5; }
    .order-item:last-child { border-bottom: none; }
    .item-img { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; background: #eee; display: flex; align-items: center; justify-content: center; color: #ccc; flex-shrink: 0; }
    .item-img img { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; }
    .item-info { flex: 1; }
    .item-name { font-size: 13px; font-weight: 600; color: #1A1A2E; }
    .item-qty { font-size: 12px; color: #aaa; margin-top: 2px; }
    .item-price { font-size: 14px; font-weight: 700; color: #2D6A4F; }

    /* Order Footer */
    .order-footer { display: flex; justify-content: flex-end; align-items: center; padding: .75rem 1.25rem; border-top: 1px solid #f5f5f5; gap: 1rem; }
    .order-total { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .order-total span { color: #2D6A4F; }

    /* Status Badge */
    .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }
    .badge-pending   { background: #FFF8E1; color: #F59E0B; }
    .badge-processing { background: #EEF2FF; color: #6366F1; }
    .badge-shipped   { background: #E0F2FE; color: #0284C7; }
    .badge-delivered { background: #E1F5EE; color: #2D6A4F; }
    .badge-cancelled { background: #FFE8E8; color: #e74c3c; }

    /* Empty State */
    .empty-state { text-align: center; padding: 3rem 1rem; color: #aaa; }
    .empty-state i { font-size: 48px; display: block; margin-bottom: 1rem; color: #ddd; }
    .empty-state p { font-size: 14px; margin-bottom: 1rem; }
    .btn-shop { display: inline-block; background: #2D6A4F; color: #fff; padding: .6rem 1.5rem; border-radius: 8px; text-decoration: none; font-size: 14px; }
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
                <a href="{{ route('front.profile') }}">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="{{ route('front.orders') }}" class="active">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="{{ route('front.bookings') }}">
                    <i class="fas fa-calendar"></i> My Bookings
                </a>
                <a href="{{ route('front.wishlist') }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="profile-content">
            <div class="content-card">
                <div class="content-title">
                    <i class="fas fa-shopping-bag" style="color:#2D6A4F;"></i>
                    My Orders ({{ $orders->count() }})
                </div>

                @if($orders->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <p>You have no orders yet!</p>
                        <a href="{{ route('front.products') }}" class="btn-shop">Start Shopping</a>
                    </div>
                @else
                    @foreach($orders as $order)
                    <div class="order-card">

                        {{-- Order Header --}}
                        <div class="order-header">
                            <div class="order-header-left">
                                <div class="order-meta">
                                    <label>Order</label>
                                    <p>#{{ $order->id }}</p>
                                </div>
                                <div class="order-meta">
                                    <label>Date</label>
                                    <p>{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="order-meta">
                                    <label>Items</label>
                                    <p>{{ $order->orderItems->count() }}</p>
                                </div>
                            </div>
                            <div>
                                @php
                                    $statusClass = match($order->order_status) {
                                        'processing' => 'badge-processing',
                                        'shipped'    => 'badge-shipped',
                                        'delivered'  => 'badge-delivered',
                                        'cancelled'  => 'badge-cancelled',
                                        default      => 'badge-pending',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="order-body">
                            @foreach($order->orderItems as $item)
                            <div class="order-item">
                                <div class="item-img">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <i class="fas fa-image"></i>
                                    @endif
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $item->product->name ?? 'Deleted Product' }}</div>
                                    <div class="item-qty">Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="item-price">${{ number_format($item->price, 2) }}</div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Order Footer --}}
                        <div class="order-footer">
                            <div class="order-total">
                                Total: <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>

                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
