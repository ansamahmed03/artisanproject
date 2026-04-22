@extends('frontend.layout.app')

@section('title', 'My Cart')

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }
    .page-title { font-size: 24px; font-weight: 700; margin-bottom: 1.5rem; }

    .cart-grid { display: grid; grid-template-columns: 1fr 340px; gap: 2rem; }

    /* Cart Items */
    .cart-card { background: #fff; border: 1px solid #eee; border-radius: 16px; overflow: hidden; }
    .cart-header { padding: 1rem 1.5rem; border-bottom: 1px solid #eee; font-size: 14px; font-weight: 600; color: #555; display: grid; grid-template-columns: 2fr 1fr 1fr 40px; gap: 1rem; align-items: center; }
    .cart-item { padding: 1rem 1.5rem; border-bottom: 1px solid #f5f5f5; display: grid; grid-template-columns: 2fr 1fr 1fr 40px; gap: 1rem; align-items: center; }
    .cart-item:last-child { border-bottom: none; }

    .item-product { display: flex; align-items: center; gap: 1rem; }
    .item-img { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; background: #F8F6F2; display: flex; align-items: center; justify-content: center; color: #ccc; flex-shrink: 0; }
    .item-img img { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; }
    .item-name { font-size: 14px; font-weight: 600; color: #1A1A2E; margin-bottom: 3px; }
    .item-cat { font-size: 12px; color: #aaa; }

    .item-price { font-size: 15px; font-weight: 700; color: #2D6A4F; }

    /* Quantity Control */
    .qty-control { display: flex; align-items: center; border: 1px solid #eee; border-radius: 50px; overflow: hidden; width: fit-content; }
    .qty-btn { width: 32px; height: 32px; background: none; border: none; font-size: 16px; cursor: pointer; color: #2D6A4F; }
    .qty-input { width: 36px; text-align: center; border: none; outline: none; font-size: 13px; font-weight: 600; }

    .remove-btn { background: none; border: none; color: #ccc; cursor: pointer; font-size: 16px; }
    .remove-btn:hover { color: #e74c3c; }

    /* Summary */
    .summary-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; position: sticky; top: 80px; height: fit-content; }
    .summary-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }
    .summary-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: .75rem; }
    .summary-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; color: #1A1A2E; padding-top: .75rem; border-top: 1px solid #eee; margin-top: .75rem; }
    .summary-total span:last-child { color: #2D6A4F; }
    .btn-checkout { width: 100%; background: #2D6A4F; color: #fff; border: none; padding: 14px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
    .btn-checkout:hover { background: #245c43; }
    .btn-continue { width: 100%; background: none; border: 1px solid #eee; color: #555; padding: 12px; border-radius: 50px; font-size: 14px; cursor: pointer; margin-top: .5rem; text-align: center; text-decoration: none; display: block; }
    .btn-continue:hover { border-color: #2D6A4F; color: #2D6A4F; }

    /* Empty */
    .empty-state { text-align: center; padding: 4rem; color: #aaa; }
    .empty-state i { font-size: 56px; display: block; margin-bottom: 1rem; color: #ddd; }
    .empty-state p { font-size: 15px; margin-bottom: 1.5rem; }
    .btn-shop { display: inline-block; background: #2D6A4F; color: #fff; padding: .75rem 2rem; border-radius: 50px; text-decoration: none; font-size: 14px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="page-title">
        <i class="fas fa-shopping-bag" style="color:#2D6A4F;"></i>
        My Cart
    </div>

    @if(session('success'))
        <div style="background:#E1F5EE;color:#2D6A4F;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:13px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="empty-state">
            <i class="fas fa-shopping-bag"></i>
            <p>Your cart is empty!</p>
            <a href="{{ route('front.products') }}" class="btn-shop">Start Shopping</a>
        </div>
    @else
        <div class="cart-grid">

            {{-- Cart Items --}}
            <div>
                <div class="cart-card">
                    <div class="cart-header">
                        <span>Product</span>
                        <span>Price</span>
                        <span>Quantity</span>
                        <span></span>
                    </div>

                    @foreach($cartItems as $item)
                    <div class="cart-item">

                        {{-- Product --}}
                        <div class="item-product">
                            <div class="item-img">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                         alt="{{ $item->product->name }}">
                                @else
                                    <i class="fas fa-image"></i>
                                @endif
                            </div>
                            <div>
                                <div class="item-name">{{ $item->product->name }}</div>
                                <div class="item-cat">{{ $item->product->category->name ?? '' }}</div>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="item-price">${{ number_format($item->product->price, 2) }}</div>

                        {{-- Quantity --}}
                        <form action="{{ route('front.cart.update', $item->id) }}" method="POST">
                            @csrf
                            <div class="qty-control">
                                <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="qty-btn">−</button>
                                <span class="qty-input">{{ $item->quantity }}</span>
                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="qty-btn">+</button>
                            </div>
                        </form>

                        {{-- Remove --}}
                        <form action="{{ route('front.cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>

                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary --}}
            <div>
                <div class="summary-card">
                    <div class="summary-title">Order Summary</div>

                    <div class="summary-row">
                        <span>Items ({{ $cartItems->sum('quantity') }})</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span style="color:#2D6A4F;">Free</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>

                <form action="{{ route('front.checkout') }}" method="POST">
    @csrf
    <button type="submit" class="btn-checkout">
        <i class="fas fa-lock"></i> Checkout
    </button>
</form>
                    <a href="{{ route('front.products') }}" class="btn-continue">
                        Continue Shopping
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection
