@extends('frontend.layout.app')

@section('title', 'My Wishlist')

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }
    .profile-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }

    /* Sidebar - نفس profile.blade.php */
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
    .content-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; }
    .content-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }

    /* Wishlist Grid */
    .wishlist-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
    .wish-card { border: 1px solid #eee; border-radius: 12px; overflow: hidden; position: relative; transition: box-shadow .2s; }
    .wish-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .wish-img { width: 100%; height: 160px; object-fit: cover; background: #F8F6F2; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 36px; }
    .wish-img img { width: 100%; height: 160px; object-fit: cover; }
    .wish-body { padding: .875rem; }
    .wish-name { font-size: 14px; font-weight: 600; color: #1A1A2E; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wish-price { font-size: 15px; font-weight: 700; color: #2D6A4F; margin-bottom: .75rem; }
    .wish-remove { position: absolute; top: 10px; right: 10px; background: #fff; border: none; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.12); color: #e74c3c; font-size: 14px; }
    .wish-remove:hover { background: #ffe0e0; }
    .btn-cart { width: 100%; background: #2D6A4F; color: #fff; border: none; border-radius: 8px; padding: .5rem; font-size: 13px; cursor: pointer; transition: background .2s; }
    .btn-cart:hover { background: #245c43; }

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
                    {{ strtoupper(substr($customer->full_name, 0, 1)) }}
                </div>
                <div class="profile-name">{{ $customer->full_name }}</div>
                <div class="profile-email">{{ $customer->email }}</div>
                <span class="profile-badge">Customer</span>
            </div>

            <div class="profile-nav">
                <a href="{{ route('front.profile') }}">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="#">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="#">
                    <i class="fas fa-calendar"></i> My Bookings
                </a>
                <a href="{{ route('front.wishlist') }}" class="active">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="profile-content">
            <div class="content-card">
                <div class="content-title">
                    <i class="fas fa-heart" style="color:#2D6A4F;"></i>
                    My Wishlist ({{ $wishlists->count() }})
                </div>

                @if($wishlists->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-heart-broken"></i>
                        <p>Your wishlist is empty!</p>
                        <a href="{{ route('front.products') }}" class="btn-shop">Browse Products</a>
                    </div>
                @else
                    <div class="wishlist-grid">
                        @foreach($wishlists as $item)
                        <div class="wish-card">
                            {{-- زر الحذف --}}
                            <form action="{{ route('front.wishlist.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="wish-remove" title="Remove">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>

                            {{-- صورة المنتج --}}
                            <div class="wish-img">
                                @if($item->product->images->first())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}">
                                @else
                                    <i class="fas fa-image"></i>
                                @endif
                            </div>

                            <div class="wish-body">
                                <div class="wish-name">{{ $item->product->name }}</div>
                                <div class="wish-price">${{ number_format($item->product->price, 2) }}</div>
                                <a href="{{ route('front.product.show', $item->product->id) }}">
                                    <button class="btn-cart">
                                        <i class="fas fa-eye"></i> View Product
                                    </button>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
