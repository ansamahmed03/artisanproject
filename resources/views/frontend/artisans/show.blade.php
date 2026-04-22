@extends('frontend.layout.app')

@section('title', $artisan->name)

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }

    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #aaa; margin-bottom: 2rem; }
    .breadcrumb a { color: #aaa; text-decoration: none; }
    .breadcrumb a:hover { color: #2D6A4F; }

    .artisan-grid { display: grid; grid-template-columns: 320px 1fr; gap: 2rem; }

    /* Left Card */
    .artisan-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 2rem; text-align: center; height: fit-content; position: sticky; top: 80px; }
    .artisan-av { width: 90px; height: 90px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: #2D6A4F; margin: 0 auto 1rem; }
    .artisan-name { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
    .artisan-city { font-size: 13px; color: #aaa; margin-bottom: 1rem; }
    .artisan-badge { display: inline-block; background: #E1F5EE; color: #2D6A4F; font-size: 11px; padding: 4px 14px; border-radius: 50px; font-weight: 600; margin-bottom: 1.5rem; }

    .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: 1rem; }
    .stat-box { background: #F8F6F2; border-radius: 10px; padding: .875rem; text-align: center; }
    .stat-num { font-size: 22px; font-weight: 700; color: #2D6A4F; }
    .stat-label { font-size: 11px; color: #aaa; margin-top: 2px; }

    /* Right Content */
    .content-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; }
    .content-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }

    /* Products */
    .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .prod-card { border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: box-shadow .2s; cursor: pointer; }
    .prod-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .prod-img { height: 140px; background: #F8F6F2; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .prod-body { padding: .875rem; }
    .prod-name { font-size: 13px; font-weight: 600; color: #1A1A2E; margin-bottom: 4px; }
    .prod-price { font-size: 14px; font-weight: 700; color: #2D6A4F; }

    /* Reviews */
    .review-card { border: 1px solid #f5f5f5; border-radius: 10px; padding: 1rem; margin-bottom: .75rem; }
    .review-header { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
    .review-av { width: 34px; height: 34px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #2D6A4F; }
    .review-name { font-size: 13px; font-weight: 600; }
    .review-date { font-size: 11px; color: #aaa; }
    .review-stars { font-size: 13px; color: #F4A261; margin-bottom: 4px; }
    .review-text { font-size: 13px; color: #666; line-height: 1.6; }

    .empty-sm { text-align: center; padding: 2rem; color: #aaa; font-size: 13px; }
</style>
@endsection

@section('content')
<div class="page-body">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('front.home') }}">Home</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <a href="{{ route('front.artisans') }}">Artisans</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <span>{{ $artisan->name }}</span>
    </div>

    <div class="artisan-grid">

        {{-- Left --}}
        <div>
            <div class="artisan-card">
                <div class="artisan-av">
                       {{ strtoupper(substr($artisan->artisan_name, 0, 2)) }}
                              </div>
                <div class="artisan-name">{{ $artisan->artisan_name }}
</div>
                <div class="artisan-city">
                    <i class="fas fa-map-marker-alt" style="color:#2D6A4F;"></i>
                {{ $artisan->city ?? '—' }}

                </div>
                <span class="artisan-badge">Artisan</span>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-num">{{ $artisan->products->count() }}</div>
                        <div class="stat-label">Products</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num">{{ $artisan->reviews->count() }}</div>
                        <div class="stat-label">Reviews</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div>
            {{-- Products --}}
            <div class="content-card">
                <div class="content-title">
                    <i class="fas fa-box" style="color:#2D6A4F;"></i>
                    Products ({{ $artisan->products->count() }})
                </div>

                @if($artisan->products->count() > 0)
                    <div class="products-grid">
                        @foreach($artisan->products as $product)
                        <div class="prod-card" onclick="window.location='{{ route('front.product.show', $product->id) }}'">
                            <div class="prod-img">
                                @if($product->images && $product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                                @else
                                    <i class="fas fa-image" style="font-size:32px;color:#ddd;"></i>
                                @endif
                            </div>
                            <div class="prod-body">
                                <div class="prod-name">{{ $product->name }}</div>
                                <div class="prod-price">${{ number_format($product->price, 2) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-sm">No products yet</div>
                @endif
            </div>

            {{-- Reviews --}}
            <div class="content-card">
                <div class="content-title">
                    <i class="fas fa-star" style="color:#F4A261;"></i>
                    Reviews ({{ $artisan->reviews->count() }})
                </div>

                @if($artisan->reviews->count() > 0)
                    @foreach($artisan->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-av">
                                {{ strtoupper(substr($review->reviewer_name ?? 'U', 0, 2)) }}
                            </div>
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
                @else
                    <div class="empty-sm">
                        <i class="fas fa-star" style="font-size:32px;color:#ddd;display:block;margin-bottom:.5rem;"></i>
                        No reviews yet
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
