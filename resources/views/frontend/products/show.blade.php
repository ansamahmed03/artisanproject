@extends('frontend.layout.app')

@section('title', $product->name)

@section('styles')
<style>
    .page-body { max-width: 1200px; margin: 0 auto; padding: 2rem; }

    /* Breadcrumb */
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #aaa; margin-bottom: 2rem; }
    .breadcrumb a { color: #aaa; text-decoration: none; }
    .breadcrumb a:hover { color: #2D6A4F; }
    .breadcrumb span { color: #1A1A2E; }

    /* Product top */
    .product-top { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }

    /* Images */
    .product-images { }
    .main-img { width: 100%; height: 420px; background: #F8F6F2; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; border: 1px solid #eee; }
    .main-img img { width: 100%; height: 100%; object-fit: cover; }
    .main-img i { font-size: 64px; color: #ddd; }
    .thumb-grid { display: flex; gap: 8px; }
    .thumb { width: 70px; height: 70px; border-radius: 8px; overflow: hidden; border: 2px solid #eee; cursor: pointer; }
    .thumb:hover { border-color: #2D6A4F; }
    .thumb.active { border-color: #2D6A4F; }
    .thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* Info */
    .product-info { }
    .prod-cat-badge { display: inline-block; background: #E1F5EE; color: #2D6A4F; font-size: 11px; padding: 4px 12px; border-radius: 50px; font-weight: 600; margin-bottom: 1rem; }
    .prod-title { font-size: 28px; font-weight: 700; margin-bottom: .5rem; line-height: 1.2; }
    .prod-artisan-row { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; }
    .artisan-av { width: 32px; height: 32px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #2D6A4F; }
    .artisan-name { font-size: 13px; color: #555; }
    .prod-rating { display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; }
    .stars { font-size: 16px; color: #F4A261; }
    .rating-count { font-size: 13px; color: #aaa; }
    .prod-price-big { font-size: 32px; font-weight: 700; color: #2D6A4F; margin-bottom: 1rem; }
    .prod-desc { font-size: 14px; color: #666; line-height: 1.7; margin-bottom: 1.5rem; }
    .prod-meta { background: #F8F6F2; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
    .prod-meta-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #eee; }
    .prod-meta-row:last-child { border-bottom: none; }
    .prod-meta-row span:first-child { color: #aaa; }
    .prod-meta-row span:last-child { font-weight: 600; color: #1A1A2E; }

    /* Quantity */
    .qty-row { display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; }
    .qty-label { font-size: 13px; color: #555; font-weight: 600; }
    .qty-control { display: flex; align-items: center; border: 1px solid #eee; border-radius: 50px; overflow: hidden; }
    .qty-btn { width: 36px; height: 36px; background: none; border: none; font-size: 18px; cursor: pointer; color: #2D6A4F; }
    .qty-input { width: 40px; text-align: center; border: none; outline: none; font-size: 14px; font-weight: 600; }

    /* Actions */
    .action-btns { display: flex; gap: 10px; margin-bottom: 1rem; }
    .btn-cart { flex: 1; background: #2D6A4F; color: #fff; border: none; padding: 14px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .btn-cart:hover { background: #245c43; }
    .btn-wish { width: 50px; height: 50px; border: 1px solid #eee; border-radius: 50%; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #aaa; }
    .btn-wish:hover { border-color: #e74c3c; color: #e74c3c; }
    .btn-wish.active { border-color: #e74c3c; color: #e74c3c; }

    /* Reviews */
    .section-title { font-size: 20px; font-weight: 700; margin-bottom: 1.5rem; }
    .reviews-grid { display: flex; flex-direction: column; gap: 16px; }
    .review-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem; }
    .review-header { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    .review-av { width: 36px; height: 36px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #2D6A4F; }
    .review-name { font-size: 14px; font-weight: 600; }
    .review-date { font-size: 11px; color: #aaa; }
    .review-stars { font-size: 13px; color: #F4A261; margin-bottom: 6px; }
    .review-text { font-size: 13px; color: #666; line-height: 1.6; }
    .no-reviews { text-align: center; padding: 3rem; color: #aaa; }
    .no-reviews i { font-size: 40px; display: block; margin-bottom: 1rem; }
</style>
@endsection

@section('content')
<div class="page-body">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('front.home') }}">Home</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <a href="{{ route('front.products') }}">Products</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <span>{{ $product->name }}</span>
    </div>

    {{-- Product Top --}}
    <div class="product-top">

        {{-- Images --}}
        <div class="product-images">
            <div class="main-img" id="mainImg">
                @if($product->images && $product->images->first())
                    <img id="mainImgEl" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-image"></i>
                @endif
            </div>
            @if($product->images && $product->images->count() > 1)
            <div class="thumb-grid">
                @foreach($product->images as $img)
                <div class="thumb {{ $loop->first ? 'active' : '' }}" onclick="changeImg('{{ asset('storage/' . $img->image_path) }}', this)">
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="product-info">
            <span class="prod-cat-badge">{{ $product->category->name ?? '' }}</span>
            <h1 class="prod-title">{{ $product->name }}</h1>

            <div class="prod-artisan-row">
                <div class="artisan-av">{{ strtoupper(substr($product->artisan->name ?? 'A', 0, 2)) }}</div>
                <span class="artisan-name">by {{ $product->artisan->name ?? 'Unknown Artisan' }}</span>
            </div>

            <div class="prod-rating">
                <span class="stars">★★★★★</span>
                <span class="rating-count">({{ $product->reviews->count() }} reviews)</span>
            </div>

            <div class="prod-price-big">${{ number_format($product->price, 2) }}</div>

            <p class="prod-desc">{{ $product->description }}</p>

            <div class="prod-meta">
                <div class="prod-meta-row">
                    <span>Status</span>
                    <span style="color:#2D6A4F">{{ ucfirst($product->status) }}</span>
                </div>
                <div class="prod-meta-row">
                    <span>Stock</span>
                    <span>{{ $product->stock_quantity }} items</span>
                </div>
                <div class="prod-meta-row">
                    <span>Category</span>
                    <span>{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="prod-meta-row">
                    <span>Artisan</span>
                    <span>{{ $product->artisan->name ?? '-' }}</span>
                </div>
            </div>

            {{-- Quantity --}}
            <div class="qty-row">
                <span class="qty-label">Quantity</span>
                <div class="qty-control">
                    <button class="qty-btn" onclick="changeQty(-1)">−</button>
                    <input type="number" class="qty-input" id="qty" value="1" min="1" max="{{ $product->stock_quantity }}">
                    <button class="qty-btn" onclick="changeQty(1)">+</button>
                </div>
            </div>

            {{-- Actions --}}
            <div class="action-btns">
                <button class="btn-cart">
                    <i class="fas fa-shopping-bag"></i> Add to Cart
                </button>
                <button class="btn-wish" id="wishBtn" onclick="toggleWishlist()">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Reviews --}}
    <div>
        <h2 class="section-title">Customer Reviews ({{ $product->reviews->count() }})</h2>

        @if($product->reviews->count() > 0)
        <div class="reviews-grid">
            @foreach($product->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-av">{{ strtoupper(substr($review->reviewer_name ?? 'U', 0, 2)) }}</div>
                    <div>
                        <div class="review-name">{{ $review->reviewer_name ?? 'Customer' }}</div>
                        <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </div>
                <div class="review-text">{{ $review->comment }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div class="no-reviews">
            <i class="fas fa-star"></i>
            <p>No reviews yet. Be the first to review this product!</p>
        </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    function changeQty(val) {
        let input = document.getElementById('qty');
        let newVal = parseInt(input.value) + val;
        let max = parseInt(input.max);
        if (newVal >= 1 && newVal <= max) input.value = newVal;
    }

    function changeImg(src, thumb) {
        document.getElementById('mainImgEl').src = src;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    function toggleWishlist() {
        let btn = document.getElementById('wishBtn');
        btn.classList.toggle('active');
    }
</script>
@endsection
