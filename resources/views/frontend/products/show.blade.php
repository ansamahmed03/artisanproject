@extends('frontend.layout.app')

@section('title', $product->name)

@section('styles')
<style>

    .star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 6px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 36px;
    color: #d1d5db;
    cursor: pointer;
    transition: color 0.15s ease, transform 0.15s ease;
    line-height: 1;
}

/* لما يحوم عليها أو على اللي قبلها */
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f59e0b;
}

.star-rating label:hover {
    transform: scale(1.2);
}

/* لما يختار */
.star-rating input:checked ~ label {
    color: #f59e0b;
}

.star-rating input:checked + label {
    transform: scale(1.15);
}

.rating-hint {
    font-size: 13px;
    color: #888;
    margin-top: 6px;
    min-height: 18px;
}
    /* تنسيق الصفحة العام */
    .page-body { max-width: 1200px; margin: 0 auto; padding: 2rem; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    /* Breadcrumb - مسار التنقل */
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #aaa; margin-bottom: 2rem; }
    .breadcrumb a { color: #aaa; text-decoration: none; }
    .breadcrumb a:hover { color: #2D6A4F; }
    .breadcrumb span { color: #1A1A2E; }

    /* الجزء العلوي للمنتج */
    .product-top { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }

    /* الصور */
    .main-img { width: 100%; height: 420px; background: #F8F6F2; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; border: 1px solid #eee; }
    .main-img img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-grid { display: flex; gap: 8px; }
    .thumb { width: 70px; height: 70px; border-radius: 8px; overflow: hidden; border: 2px solid #eee; cursor: pointer; transition: 0.3s; }
    .thumb.active, .thumb:hover { border-color: #2D6A4F; }
    .thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* تفاصيل المنتج */
    .prod-cat-badge { display: inline-block; background: #E1F5EE; color: #2D6A4F; font-size: 11px; padding: 4px 12px; border-radius: 50px; font-weight: 600; margin-bottom: 1rem; }
    .prod-title { font-size: 28px; font-weight: 700; margin-bottom: .5rem; color: #1A1A2E; }
    .prod-price-big { font-size: 32px; font-weight: 700; color: #2D6A4F; margin-bottom: 1.5rem; }
    .prod-desc { font-size: 14px; color: #666; line-height: 1.7; margin-bottom: 1.5rem; }

    /* الميتا والبيانات */
    .prod-meta { background: #F8F6F2; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
    .prod-meta-row { display: flex; justify-content: space-between; font-size: 13px; padding: 8px 0; border-bottom: 1px solid #eee; }
    .prod-meta-row:last-child { border-bottom: none; }
    .prod-meta-row span:first-child { color: #888; }
    .prod-meta-row span:last-child { font-weight: 600; color: #1A1A2E; }

    /* الأزرار والكمية */
    .qty-row { display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; }
    .qty-control { display: flex; align-items: center; border: 1px solid #eee; border-radius: 50px; overflow: hidden; background: #fff; }
    .qty-btn { width: 36px; height: 36px; background: none; border: none; font-size: 18px; cursor: pointer; color: #2D6A4F; }
    .qty-input { width: 40px; text-align: center; border: none; outline: none; font-weight: 600; }

    .action-btns { display: flex; gap: 10px; }
    .btn-cart { flex: 1; background: #2D6A4F; color: #fff; border: none; padding: 14px; border-radius: 50px; font-weight: 600; cursor: pointer; transition: 0.3s; text-align: center; text-decoration: none; }
    .btn-cart:hover { background: #245c43; }
    .btn-wish { width: 50px; height: 50px; border: 1px solid #eee; border-radius: 50%; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #aaa; }
    .btn-wish.active { color: #e74c3c; border-color: #e74c3c; }

    /* التقييمات */
    .section-title { font-size: 20px; font-weight: 700; margin: 2rem 0 1.5rem; }
    .review-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem; }
    .review-header { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .review-av { width: 40px; height: 40px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #2D6A4F; }

    /* فورم إضافة تقييم */
    .review-form-container { background: #F8F6F2; padding: 2rem; border-radius: 16px; margin-top: 2rem; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem; font-family: inherit; }
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

    {{-- Product Top Section --}}
    <div class="product-top">
        {{-- Images --}}
        <div class="product-images">
            <div class="main-img" id="mainImg">
                @if($product->images->count() > 0)
                    <img id="mainImgEl" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-image" style="font-size: 64px; color: #ddd;"></i>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="thumb-grid">
                @foreach($product->images as $img)
                <div class="thumb {{ $loop->first ? 'active' : '' }}" onclick="changeImg('{{ asset('storage/' . $img->image_path) }}', this)">
                    <img src="{{ asset('storage/' . $img->image_path) }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="product-info">
            <span class="prod-cat-badge">{{ $product->category->name ?? 'Uncategorized' }}</span>
            <h1 class="prod-title">{{ $product->name }}</h1>

            <div class="prod-price-big">${{ number_format($product->price, 2) }}</div>
            <p class="prod-desc">{{ $product->description }}</p>

            <div class="prod-meta">
                <div class="prod-meta-row">
                    <span>Availability</span>
                    <span style="color:#2D6A4F">{{ ucfirst($product->status) }}</span>
                </div>
                <div class="prod-meta-row">
                    <span>Stock</span>
                    <span>{{ $product->stock_quantity }} units</span>
                </div>
            </div>

            {{-- Cart Form --}}
            <form action="{{ route('front.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="qty-row">
                    <span class="qty-label">Quantity</span>
                    <div class="qty-control">
                        <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                        <input type="number" class="qty-input" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                        <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                </div>

                <div class="action-btns">
                    @auth('customer')
                        <button type="submit" class="btn-cart">Add to Cart</button>
                    @else
                        <a href="{{ route('front.login') }}" class="btn-cart">Login to Buy</a>
                    @endauth
                </div>
            </form>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews-section">
        <h2 class="section-title">Reviews ({{ $product->reviews->count() }})</h2>

        @forelse($product->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-av">{{ strtoupper(substr($review->customer->name ?? 'U', 0, 1)) }}</div>
                    <div>
                        <div style="font-weight:600">{{ $review->customer->name ?? 'Customer' }}</div>
                        <div style="font-size:11px; color:#aaa">{{ $review->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                <div style="color: #F4A261; margin-bottom: 8px;">
                    {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                </div>
                <p style="font-size: 14px; color: #555;">{{ $review->comment }}</p>
            </div>
        @empty
            <p style="color:#aaa; text-align:center; padding: 2rem;">No reviews yet. Be the first!</p>
        @endforelse

        {{-- Add Review Form --}}
@auth('customer')
<div class="review-form-container">
    <h3>Add a Review</h3>
    <form action="{{ route('review.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <label>Rating</label>
        <div class="star-rating-wrapper">
            <div class="star-rating">
                <input type="radio" name="rating" id="star5" value="5" required>
                <label for="star5" title="5 - Excellent">★</label>
                <input type="radio" name="rating" id="star4" value="4">
                <label for="star4" title="4 - Good">★</label>
                <input type="radio" name="rating" id="star3" value="3">
                <label for="star3" title="3 - Average">★</label>
                <input type="radio" name="rating" id="star2" value="2">
                <label for="star2" title="2 - Poor">★</label>
                <input type="radio" name="rating" id="star1" value="1">
                <label for="star1" title="1 - Awful">★</label>
            </div>
            <p id="rating-text" class="rating-hint">Select your rating</p>
        </div>

        <label>Comment</label>
        <textarea name="comment" class="form-control" rows="4"
                  placeholder="Your experience..." required></textarea>

        <button type="submit" class="btn-cart"
                style="width: auto; padding: 12px 40px;">Submit Review</button>
    </form>
</div>
@endauth
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
    const ratingLabels = {
    1: 'Awful — 1 star',
    2: 'Poor — 2 stars',
    3: 'Average — 3 stars',
    4: 'Good — 4 stars',
    5: 'Excellent — 5 stars'
};

document.querySelectorAll('.star-rating input').forEach(input => {
    input.addEventListener('change', function () {
        document.getElementById('rating-text').textContent = ratingLabels[this.value];
    });
});
</script>
@endsection
