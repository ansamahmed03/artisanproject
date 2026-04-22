@extends('frontend.layout.app')

@section('title', 'Artisans')

@section('styles')
<style>
    .page-header { text-align: center; padding: 3rem 2rem 2rem; }
    .page-header h1 { font-size: 36px; font-weight: 700; margin-bottom: .5rem; }
    .page-header p { font-size: 14px; color: #888; }

    .page-body { max-width: 1200px; margin: 0 auto; padding: 2rem; }

    .artisans-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

    .artisan-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; transition: box-shadow .2s; }
    .artisan-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

    .artisan-top { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .artisan-av { width: 56px; height: 56px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #2D6A4F; flex-shrink: 0; }
    .artisan-name { font-size: 16px; font-weight: 700; color: #1A1A2E; }
    .artisan-city { font-size: 13px; color: #aaa; margin-top: 2px; }

    .artisan-badge { display: inline-block; background: #E1F5EE; color: #2D6A4F; font-size: 11px; padding: 3px 10px; border-radius: 50px; font-weight: 600; margin-bottom: 1rem; }

    .artisan-stats { display: flex; gap: 1rem; margin-bottom: 1rem; }
    .artisan-stat { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #888; }
    .artisan-stat i { color: #2D6A4F; font-size: 11px; }

    .artisan-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f5f5f5; padding-top: 1rem; margin-top: .5rem; }
    .artisan-products { font-size: 13px; color: #888; }
    .btn-view { background: #2D6A4F; color: #fff; padding: 8px 20px; border-radius: 50px; text-decoration: none; font-size: 13px; font-weight: 600; }
    .btn-view:hover { background: #245c43; }

    .empty { text-align: center; padding: 4rem; color: #aaa; }
    .empty i { font-size: 48px; display: block; margin-bottom: 1rem; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h1>Our Artisans</h1>
    <p>Discover talented artisans and their handcrafted creations</p>
</div>

<div class="page-body">
    @if($artisans->count() > 0)
        <div class="artisans-grid">
            @foreach($artisans as $artisan)
            <div class="artisan-card">
                <div class="artisan-top">
                    <div class="artisan-av">
                       {{ strtoupper(substr($artisan->artisan_name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="artisan-name">{{ $artisan->artisan_name }}</div>
                        <div class="artisan-city">
                            <i class="fas fa-map-marker-alt" style="color:#2D6A4F;font-size:11px;"></i>
                            {{ $artisan->city ?? '—' }}
                        </div>
                    </div>
                </div>

                <span class="artisan-badge">Artisan</span>

                <div class="artisan-stats">
                    <div class="artisan-stat">
                        <i class="fas fa-box"></i>
                        {{ $artisan->products_count ?? $artisan->products->count() }} Products
                    </div>
                    <div class="artisan-stat">
                        <i class="fas fa-star"></i>
                        {{ $artisan->reviews_count ?? $artisan->reviews->count() }} Reviews
                    </div>
                </div>

                <div class="artisan-footer">
                    <span class="artisan-products">
                        {{ $artisan->products_count ?? $artisan->products->count() }} items available
                    </span>
                    <a href="{{ route('front.artisan.show', $artisan->id) }}" class="btn-view">
                        View Profile
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <i class="fas fa-paint-brush"></i>
            <p>No artisans found</p>
        </div>
    @endif
</div>

@endsection
