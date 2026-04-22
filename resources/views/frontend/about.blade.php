@extends('frontend.layout.app')

@section('title', 'About Us')

@section('styles')
<style>
    /* Hero */
    .about-hero { background: linear-gradient(135deg, #2D6A4F 0%, #2D6A4F 100%); color: #fff; padding: 5rem 2rem; text-align: center; }
    .about-hero h1 { font-size: 48px; font-weight: 700; margin-bottom: 1rem; }
    .about-hero p { font-size: 18px; color: rgba(255,255,255,.75); max-width: 600px; margin: 0 auto; line-height: 1.7; }

    /* Section */
    .section { padding: 5rem 2rem; max-width: 1100px; margin: 0 auto; }
    .section-label { font-size: 12px; font-weight: 700; color: #2D6A4F; text-transform: uppercase; letter-spacing: .1em; margin-bottom: .5rem; }
    .section-title { font-size: 32px; font-weight: 700; color: #1A1A2E; margin-bottom: 1rem; }
    .section-text { font-size: 15px; color: #666; line-height: 1.8; max-width: 640px; }

    /* Story */
    .story-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
    .story-img { background: #E1F5EE; border-radius: 20px; height: 360px; display: flex; align-items: center; justify-content: center; }
    .story-img i { font-size: 80px; color: #2D6A4F; opacity: .4; }

    /* Stats */
    .stats-section { background: #2D6A4F; padding: 4rem 2rem; }
    .stats-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
    .stat-item { color: #fff; }
    .stat-num { font-size: 48px; font-weight: 700; color: #fff; }
    .stat-label { font-size: 14px; color: rgba(255,255,255,.6); margin-top: 4px; }

    /* Values */
    .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
    .value-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 2rem; text-align: center; }
    .value-icon { width: 60px; height: 60px; background: #E1F5EE; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 24px; color: #2D6A4F; }
    .value-title { font-size: 16px; font-weight: 700; margin-bottom: .5rem; }
    .value-text { font-size: 13px; color: #888; line-height: 1.6; }

    /* Team */
    .team-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 2rem; }
    .team-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; text-align: center; }
    .team-av { width: 70px; height: 70px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; color: #2D6A4F; margin: 0 auto 1rem; }
    .team-name { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
    .team-role { font-size: 12px; color: #2D6A4F; font-weight: 600; }

    /* CTA */
    .cta-section { background: #F8F6F2; padding: 5rem 2rem; text-align: center; }
    .cta-section h2 { font-size: 32px; font-weight: 700; margin-bottom: 1rem; }
    .cta-section p { font-size: 15px; color: #888; margin-bottom: 2rem; }
    .cta-btns { display: flex; gap: 1rem; justify-content: center; }
    .btn-primary { background: #2D6A4F; color: #fff; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-size: 15px; font-weight: 600; }
    .btn-primary:hover { background: #245c43; }
    .btn-outline { border: 2px solid #2D6A4F; color: #2D6A4F; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-size: 15px; font-weight: 600; }
    .btn-outline:hover { background: #2D6A4F; color: #fff; }

    .divider { border: none; border-top: 1px solid #eee; margin: 0; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="about-hero">
    <h1>Crafted with Passion</h1>
    <p>We connect talented artisans with people who appreciate the beauty of handcrafted work — one unique piece at a time.</p>
</div>

{{-- Our Story --}}
<div class="section">
    <div class="story-grid">
        <div>
            <div class="section-label">Our Story</div>
            <h2 class="section-title">Born from a Love of Craftsmanship</h2>
            <p class="section-text">
                ArtisanHub was founded with a simple mission: to give talented artisans a platform to share their work with the world. We believe that handcrafted goods carry a unique story — the time, skill, and love that goes into every piece.
            </p>
            <p class="section-text" style="margin-top:1rem;">
                From hand-woven textiles to hand-thrown pottery, every item on our platform is made by real people with real passion. We're proud to support local artisans and bring their creations to a global audience.
            </p>
        </div>
        <div class="story-img">
            <i class="fas fa-paint-brush"></i>
        </div>
    </div>
</div>

<hr class="divider">

{{-- Stats --}}
<div class="stats-section">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-num">500+</div>
            <div class="stat-label">Artisans</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">2K+</div>
            <div class="stat-label">Handcrafted Products</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">10K+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">50+</div>
            <div class="stat-label">Cities Covered</div>
        </div>
    </div>
</div>

{{-- Values --}}
<div class="section">
    <div style="text-align:center;margin-bottom:.5rem;">
        <div class="section-label" style="justify-content:center;display:block;">What We Stand For</div>
        <h2 class="section-title" style="text-align:center;">Our Values</h2>
    </div>
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-heart"></i></div>
            <div class="value-title">Passion & Quality</div>
            <p class="value-text">Every product is handpicked and verified to ensure it meets our quality standards.</p>
        </div>
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-hands-helping"></i></div>
            <div class="value-title">Supporting Artisans</div>
            <p class="value-text">We empower local artisans by giving them the tools and platform they need to thrive.</p>
        </div>
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-leaf"></i></div>
            <div class="value-title">Sustainability</div>
            <p class="value-text">We champion sustainable practices and eco-friendly materials across our community.</p>
        </div>
    </div>
</div>

<hr class="divider">

{{-- Team --}}
<div class="section">
    <div style="text-align:center;margin-bottom:.5rem;">
        <div class="section-label" style="display:block;">The People Behind ArtisanHub</div>
        <h2 class="section-title" style="text-align:center;">Meet Our Team</h2>
    </div>
   <div class="team-grid">
    @foreach($admins as $admin)
    <div class="team-card">
        <div class="team-av">
            {{ strtoupper(substr($admin->full_name, 0, 2)) }}
        </div>
        <div class="team-name">{{ $admin->full_name }}</div>
        <div class="team-role">Admin</div>
    </div>
    @endforeach
</div>
</div>

{{-- CTA --}}
<div class="cta-section">
    <h2>Ready to Explore?</h2>
    <p>Discover thousands of unique handcrafted pieces from talented artisans.</p>
    <div class="cta-btns">
        <a href="{{ route('front.products') }}" class="btn-primary">Shop Now</a>
        <a href="{{ route('front.contact') }}" class="btn-outline">Contact Us</a>
    </div>
</div>

@endsection
