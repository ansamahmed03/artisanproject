@extends('frontend.layout.app')

@section('title', 'Products')

@section('styles')
<style>
    .page-header { background: #F8F6F2; padding: 3rem 2rem; border-bottom: 1px solid #eee; }
    .page-header h1 { font-size: 36px; font-weight: 700; margin-bottom: .5rem; }
    .page-header p { font-size: 14px; color: #888; }

    .page-body { display: flex; gap: 2rem; padding: 2rem; max-width: 1400px; margin: 0 auto; }

    /* Sidebar */
    .sidebar { width: 240px; flex-shrink: 0; }
    .filter-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem; }
    .filter-card h3 { font-size: 14px; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; }
    .filter-option { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
    .filter-option label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; cursor: pointer; }
    .filter-option input[type=checkbox] { accent-color: #2D6A4F; }
    .filter-count { font-size: 11px; color: #aaa; }
    .price-slider { width: 100%; accent-color: #2D6A4F; margin: 8px 0; }
    .price-labels { display: flex; justify-content: space-between; font-size: 12px; color: #888; }
    .clear-btn { font-size: 12px; color: #2D6A4F; background: none; border: none; cursor: pointer; }

    /* Products area */
    .products-area { flex: 1; }
    .results-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
    .results-count { font-size: 13px; color: #888; }
    .sort-select { font-size: 13px; padding: 6px 12px; border: 1px solid #eee; border-radius: 50px; outline: none; }

    .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .prod-card { background: #fff; border: 1px solid #eee; border-radius: 12px; overflow: hidden; cursor: pointer; transition: border-color .2s; }
    .prod-card:hover { border-color: #2D6A4F; }
    .prod-card:hover .wishlist-btn { opacity: 1; }
    .prod-img { height: 200px; background: #F8F6F2; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
    .prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .prod-img-placeholder { font-size: 48px; color: #ddd; }
    .wishlist-btn { position: absolute; top: 10px; right: 10px; width: 34px; height: 34px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #eee; cursor: pointer; opacity: 0; transition: opacity .2s; }
    .wishlist-btn:hover i { color: #e74c3c; }
    .wishlist-btn.active { opacity: 1; }
    .wishlist-btn.active i { color: #e74c3c; }
    .prod-body { padding: 1rem; }
    .prod-cat { font-size: 11px; color: #2D6A4F; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
    .prod-name { font-size: 15px; font-weight: 600; color: #1A1A2E; margin-bottom: 3px; }
    .prod-artisan { font-size: 12px; color: #aaa; margin-bottom: 10px; }
    .prod-footer { display: flex; align-items: center; justify-content: space-between; }
    .prod-price { font-size: 16px; font-weight: 700; color: #2D6A4F; }
    .prod-stars { font-size: 12px; color: #F4A261; }
    .prod-stock { font-size: 11px; color: #aaa; }

    /* Pagination */
    .pagination-wrap { display: flex; justify-content: center; margin-top: 2rem; gap: 6px; }
    .pagination-wrap a, .pagination-wrap span { padding: 6px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 13px; text-decoration: none; color: #555; }
    .pagination-wrap .active span { background: #2D6A4F; color: #fff; border-color: #2D6A4F; }

    /* Empty */
    .empty { text-align: center; padding: 4rem; color: #aaa; }
    .empty i { font-size: 48px; margin-bottom: 1rem; display: block; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h1>Discover Handcrafted Treasures</h1>
    <p>{{ $products->total() }} unique pieces from talented artisans</p>
</div>

<div class="page-body">

    {{-- Sidebar Filters --}}
    <div class="sidebar">
        <form method="GET" action="{{ route('front.products') }}" id="filterForm">

            <div class="filter-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
                    <span style="font-size:15px;font-weight:700;">Filters</span>
                    <a href="{{ route('front.products') }}" class="clear-btn">Clear all</a>
                </div>
            </div>

            <div class="filter-card">
                <h3>Category</h3>
             @foreach($categories as $cat)
<div class="filter-option">
    <label>
        <input type="checkbox" name="category[]" value="{{ $cat->id }}"
            {{ in_array($cat->id, request('category', [])) ? 'checked' : '' }}
            onchange="document.getElementById('filterForm').submit()">
        {{ $cat->name }}
    </label>
    <span class="filter-count">{{ $cat->products_count ?? '' }}</span>
</div>
@endforeach
            </div>

            <div class="filter-card">
                <h3>Price Range</h3>
                <input type="range" class="price-slider" min="0" max="1000" step="10"
                    value="{{ request('max_price', 1000) }}" id="priceRange"
                    oninput="document.getElementById('priceVal').textContent = '$'+this.value"
                    onchange="document.getElementById('filterForm').submit()">
                <input type="hidden" name="max_price" id="maxPriceInput" value="{{ request('max_price', 1000) }}">
                <div class="price-labels">
                    <span>$0</span>
                    <span id="priceVal">${{ request('max_price', 1000) }}</span>
                </div>
            </div>

            <div class="filter-card">
                <h3>Sort by</h3>
                <select name="sort" class="sort-select" style="width:100%" onchange="document.getElementById('filterForm').submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>

        </form>
    </div>

    {{-- Products --}}
    <div class="products-area">
        <div class="results-bar">
            <span class="results-count">Showing {{ $products->count() }} of {{ $products->total() }} products</span>
        </div>

        @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
            <div class="prod-card" onclick="window.location='{{ route('front.product.show', $product->id) }}'">
                <div class="prod-img">
                    @if($product->images && $product->images->where('is_primary', 1)->first())
                        <img src="{{ asset('storage/' . $product->images->where('is_primary', 1)->first()->image_path) }}" alt="{{ $product->name }}">
                    @elseif($product->images && $product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image prod-img-placeholder"></i>
                    @endif
                    <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="prod-body">
                    <div class="prod-cat">{{ $product->category->name ?? '' }}</div>
                    <div class="prod-name">{{ $product->name }}</div>
                    <div class="prod-artisan">by {{ $product->artisan->artisan_name
                     ?? '' }}</div>
                    <div class="prod-footer">
                        <span class="prod-price">${{ number_format($product->price, 2) }}</span>
                        <span class="prod-stars">★★★★★</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $products->appends(request()->query())->links() }}
        </div>

        @else
        <div class="empty">
            <i class="fas fa-search"></i>
            <p>No products found</p>
        </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.getElementById('priceRange').addEventListener('change', function() {
        document.getElementById('maxPriceInput').value = this.value;
    });

    function toggleWishlist(btn) {
        btn.classList.toggle('active');
    }
</script>
@endsection
