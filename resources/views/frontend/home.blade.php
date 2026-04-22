@extends('frontend.layout.app')

@section('title', 'Home')

@section('styles')
<style>
    /* Hero */
    .hero { background: #F8F6F2; padding: 5rem 2rem; text-align: center; border-bottom: 1px solid #eee; }
    .hero-tag { display: inline-block; background: #E1F5EE; color: #2D6A4F; font-size: 11px; padding: 4px 14px; border-radius: 50px; letter-spacing: .08em; margin-bottom: 1.5rem; }
    .hero h1 { font-size: 48px; font-weight: 700; line-height: 1.15; margin-bottom: 1rem; max-width: 700px; margin-left: auto; margin-right: auto; }
    .hero p { font-size: 16px; color: #666; max-width: 500px; margin: 0 auto 2rem; line-height: 1.7; }
    .hero-btns { display: flex; gap: 12px; justify-content: center; }
    .btn-green { background: #2D6A4F; color: #fff; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-size: 14px; font-weight: 500; }
    .btn-green:hover { background: #245c43; }
    .btn-ghost { background: transparent; color: #2D6A4F; border: 1px solid #2D6A4F; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-size: 14px; }
    .btn-ghost:hover { background: #2D6A4F; color: #fff; }

    /* Stats */
    .stats { display: flex; justify-content: center; gap: 4rem; padding: 2.5rem 2rem; background: #fff; border-bottom: 1px solid #eee; }
    .stat-num { font-size: 28px; font-weight: 700; color: #2D6A4F; }
    .stat-label { font-size: 13px; color: #888; margin-top: 2px; }

    /* Section */
    .section { padding: 3rem 2rem; }
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .section-title { font-size: 22px; font-weight: 700; }
    .see-all { font-size: 13px; color: #2D6A4F; text-decoration: none; }
    .see-all:hover { text-decoration: underline; }

    /* Categories */
    .cats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
    .cat-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem; text-align: center; cursor: pointer; transition: border-color .2s; text-decoration: none; }
    .cat-card:hover { border-color: #2D6A4F; }
    .cat-icon { width: 48px; height: 48px; background: #E1F5EE; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }
    .cat-icon i { color: #2D6A4F; font-size: 18px; }
    .cat-name { font-size: 13px; font-weight: 600; color: #1A1A2E; }
    .cat-count { font-size: 11px; color: #aaa; margin-top: 2px; }

    /* Products */
    .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    .prod-card { background: #fff; border: 1px solid #eee; border-radius: 12px; overflow: hidden; cursor: pointer; transition: border-color .2s; position: relative; }
    .prod-card:hover { border-color: #2D6A4F; }
    .prod-card:hover .wishlist-btn { opacity: 1; }
    .prod-img { height: 180px; background: #F8F6F2; display: flex; align-items: center; justify-content: center; position: relative; }
    .prod-img i { font-size: 40px; color: #ddd; }
    .wishlist-btn { position: absolute; top: 10px; right: 10px; width: 32px; height: 32px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #eee; cursor: pointer; opacity: 0; transition: opacity .2s; }
    .wishlist-btn i { font-size: 14px; color: #aaa; }
    .wishlist-btn.active i { color: #e74c3c; }
    .wishlist-btn:hover i { color: #e74c3c; }
    .prod-body { padding: .875rem; }
    .prod-cat { font-size: 11px; color: #2D6A4F; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
    .prod-name { font-size: 14px; font-weight: 600; color: #1A1A2E; margin-bottom: 3px; }
    .prod-artisan { font-size: 12px; color: #aaa; margin-bottom: 8px; }
    .prod-footer { display: flex; align-items: center; justify-content: space-between; }
    .prod-price { font-size: 15px; font-weight: 700; color: #2D6A4F; }
    .prod-stars { font-size: 11px; color: #F4A261; }

    /* Teams */
    .teams-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .team-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem; }
    .team-card:hover { border-color: #2D6A4F; }
    .team-avatar { width: 48px; height: 48px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: #2D6A4F; }
    .team-name { font-size: 15px; font-weight: 600; margin-bottom: 2px; }
    .team-type { font-size: 12px; color: #aaa; margin-bottom: 10px; }
    .team-desc { font-size: 13px; color: #666; line-height: 1.6; margin-bottom: 12px; }
    .team-footer { display: flex; align-items: center; justify-content: space-between; }
    .team-price { font-size: 13px; color: #2D6A4F; font-weight: 600; }
    .book-btn { background: #2D6A4F; color: #fff; border: none; padding: 6px 16px; border-radius: 50px; font-size: 12px; cursor: pointer; text-decoration: none; }
    .book-btn:hover { background: #245c43; }

    /* CTA */
    .cta { background: #2D6A4F; padding: 4rem 2rem; text-align: center; margin-top: 2rem; }
    .cta h2 { font-size: 28px; font-weight: 700; color: #fff; margin-bottom: .75rem; }
    .cta p { font-size: 15px; color: rgba(255,255,255,.75); margin-bottom: 2rem; }
    .cta-btns { display: flex; gap: 12px; justify-content: center; }
    .btn-white { background: #fff; color: #2D6A4F; padding: 12px 28px; border-radius: 50px; text-decoration: none; font-size: 14px; font-weight: 600; }
    .btn-white-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.5); padding: 12px 28px; border-radius: 50px; text-decoration: none; font-size: 14px; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="hero">
    <span class="hero-tag">HANDCRAFTED WITH LOVE</span>
    <h1>Where Tradition Meets Contemporary Craftsmanship</h1>
    <p>Explore unique handmade pieces from skilled artisans. Each item tells a story of heritage, passion, and exceptional craftsmanship.</p>
    <div class="hero-btns">
        <a href="{{ route('front.products') }}" class="btn-green">Explore products</a>
         <a href="#" class="btn-ghost">Book a team</a>
    </div>
</div>

{{-- Stats --}}
<div class="stats">
    <div class="text-center">
        <div class="stat-num">240+</div>
        <div class="stat-label">Artisans</div>
    </div>
    <div class="text-center">
        <div class="stat-num">1.2k</div>
        <div class="stat-label">Products</div>
    </div>
    <div class="text-center">
        <div class="stat-num">85+</div>
        <div class="stat-label">Teams</div>
    </div>
    <div class="text-center">
        <div class="stat-num">4.9</div>
        <div class="stat-label">Avg Rating</div>
    </div>
</div>

{{-- Categories --}}

<div class="section" style="background:#fff;">
    <div class="section-header">
        <span class="section-title">Browse by category</span>
        <a href="{{ route('front.products') }}" class="see-all">See all →</a>
    </div>
    <div class="cats-grid">
        @php
        $images = [
            'Pottery'    => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=200',
             'Embroidery' => 'https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=200',
            'Woodwork'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200',
            'Jewelry'    => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=200',
            'Glasswork'  => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=200',
        ];
        @endphp

        @foreach($categories as $cat)
       <a href="{{ route('front.products', ['category' => $cat->id]) }}" class="cat-card">
    <div style="width:80px;height:80px;overflow:hidden;border-radius:12px;margin:0 auto 12px;">
        <img src="{{ $images[$cat->name] ?? '' }}"
             style="width:100%;height:100%;object-fit:cover;">
    </div>
    <div class="cat-name">{{ $cat->name }}</div>
    <div class="cat-count">{{ $cat->products_count ?? 0 }} items</div>
</a>
        @endforeach

    </div>
</div>
{{-- Featured Products --}}
<div class="section">
    <div class="section-header">
        <span class="section-title">Featured products</span>
<a href="{{ route('front.products') }}" class="see-all">See all →</a>    </div>
    <div class="products-grid">
        @foreach($featuredProducts as $product)
  <div class="prod-card" onclick="window.location='{{ route('front.product.show', $product->id) }}'" style="cursor:pointer;">
         <div class="prod-img">
    @if($product->images && $product->images->first())
        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
             alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
    @else
        <i class="fas fa-image" style="font-size:40px;color:#ddd;"></i>
    @endif
</div>
            <div class="prod-body">
                <div class="prod-cat">{{ $product->category->name ?? '' }}</div>
                <div class="prod-name">{{ $product->name }}</div>
                <div class="prod-artisan">by {{ $product->artisan->artisan_name ?? '' }}</div>
                <div class="prod-footer">
                    <span class="prod-price">${{ $product->price }}</span>
                    <span class="prod-stars">★★★★★</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- CTA --}}
<div class="cta">
    <h2>Are you an artisan or team leader?</h2>
    <p>Join ArtisanHub and reach thousands of customers who love authentic handmade crafts.</p>
    <div class="cta-btns">
        <a href="#" class="btn-white">Join as artisan</a>
        <a href="#" class="btn-white-ghost">Register a team</a>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleWishlist(btn) {
        btn.classList.toggle('active');
    }
</script>
@endsection
