@extends('frontend.layout.app')

@section('title', 'Search Results')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:2rem;">

    <h2 style="font-size:22px; font-weight:700; margin-bottom:.5rem;">
        Search Results for "<span style="color:#2D6A4F;">{{ $q }}</span>"
    </h2>
    <p style="color:#aaa; font-size:14px; margin-bottom:2rem;">
        {{ $products->count() + $artisans->count() + $teams->count() }} results found
    </p>

    {{-- Products --}}
    @if($products->count() > 0)
    <div style="margin-bottom:2.5rem;">
        <h3 style="font-size:16px; font-weight:700; margin-bottom:1rem; padding-bottom:.5rem; border-bottom:1px solid #eee;">
            <i class="fas fa-box" style="color:#2D6A4F;"></i> Products ({{ $products->count() }})
        </h3>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem;">
            @foreach($products as $product)
            <a href="{{ route('front.product.show', $product->id) }}" style="text-decoration:none;">
                <div style="border:1px solid #eee; border-radius:12px; overflow:hidden; transition:box-shadow .2s;">
                    <div style="height:140px; background:#F8F6F2; overflow:hidden;">
                        @if($product->images && $product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="height:100%; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-image" style="font-size:32px; color:#ddd;"></i>
                            </div>
                        @endif
                    </div>
                    <div style="padding:.875rem;">
                        <div style="font-size:13px; font-weight:600; color:#1A1A2E; margin-bottom:4px;">{{ $product->name }}</div>
                        <div style="font-size:14px; font-weight:700; color:#2D6A4F;">${{ number_format($product->price, 2) }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Artisans --}}
    @if($artisans->count() > 0)
    <div style="margin-bottom:2.5rem;">
        <h3 style="font-size:16px; font-weight:700; margin-bottom:1rem; padding-bottom:.5rem; border-bottom:1px solid #eee;">
            <i class="fas fa-user" style="color:#2D6A4F;"></i> Artisans ({{ $artisans->count() }})
        </h3>
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
            @foreach($artisans as $artisan)
            <a href="{{ route('front.artisan.show', $artisan->id) }}" style="text-decoration:none;">
                <div style="border:1px solid #eee; border-radius:12px; padding:1.25rem; text-align:center;">
                    <div style="width:50px; height:50px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:700; color:#2D6A4F; margin:0 auto .75rem;">
                        {{ strtoupper(substr($artisan->artisan_name, 0, 2)) }}
                    </div>
                    <div style="font-size:13px; font-weight:600; color:#1A1A2E;">{{ $artisan->artisan_name }}</div>
                    <div style="font-size:12px; color:#aaa;">{{ $artisan->store_name }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Teams --}}
    @if($teams->count() > 0)
    <div style="margin-bottom:2.5rem;">
        <h3 style="font-size:16px; font-weight:700; margin-bottom:1rem; padding-bottom:.5rem; border-bottom:1px solid #eee;">
            <i class="fas fa-users" style="color:#2D6A4F;"></i> Teams ({{ $teams->count() }})
        </h3>
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
            @foreach($teams as $team)
            <a href="{{ route('front.team.show', $team->id) }}" style="text-decoration:none;">
                <div style="border:1px solid #eee; border-radius:12px; padding:1.25rem; text-align:center;">
                    <div style="width:50px; height:50px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:700; color:#2D6A4F; margin:0 auto .75rem;">
                        {{ strtoupper(substr($team->team_name, 0, 2)) }}
                    </div>
                    <div style="font-size:13px; font-weight:600; color:#1A1A2E;">{{ $team->team_name }}</div>
                    <div style="font-size:12px; color:#aaa;">{{ $team->city->name ?? '—' }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- No Results --}}
    @if($products->count() == 0 && $artisans->count() == 0 && $teams->count() == 0)
    <div style="text-align:center; padding:4rem; color:#aaa;">
        <i class="fas fa-search" style="font-size:48px; display:block; margin-bottom:1rem; color:#ddd;"></i>
        <p style="font-size:16px;">No results found for "{{ $q }}"</p>
        <a href="{{ route('front.products') }}" style="color:#2D6A4F; font-weight:600; text-decoration:none;">Browse all products →</a>
    </div>
    @endif

</div>
@endsection
