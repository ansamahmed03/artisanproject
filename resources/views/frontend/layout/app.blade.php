<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtisanHub - @yield('title', 'Handcrafted Treasures')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #F8F6F2; color: #1A1A2E; }

        /* Navbar */
        .navbar { background: #fff; border-bottom: 1px solid #eee; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; height: 64px; position: sticky; top: 0; z-index: 100; }
        .nav-logo { font-size: 20px; font-weight: 700; color: #2D6A4F; text-decoration: none; }
        .nav-logo span { color: #1A1A2E; }
        .nav-links { display: flex; gap: 2rem; }
        .nav-links a { font-size: 14px; color: #555; text-decoration: none; }
        .nav-links a:hover { color: #2D6A4F; }
        .nav-search { display: flex; align-items: center; background: #F8F6F2; border: 1px solid #eee; border-radius: 50px; padding: 6px 16px; gap: 8px; width: 260px; }
        .nav-search input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; }
        .nav-actions { display: flex; align-items: center; gap: 1rem; }
        .nav-actions a { color: #555; text-decoration: none; font-size: 18px; }
        .nav-actions a:hover { color: #2D6A4F; }
        .btn-signin { font-size: 13px; color: #2D6A4F; border: 1px solid #2D6A4F; padding: 6px 16px; border-radius: 50px; text-decoration: none; }
        .btn-signin:hover { background: #2D6A4F; color: #fff; }

        /* Footer */
        .footer { background: #fff; border-top: 1px solid #eee; padding: 3rem 2rem 1.5rem; margin-top: 4rem; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
        .footer-brand p { font-size: 13px; color: #888; margin-top: 8px; line-height: 1.6; max-width: 220px; }
        .footer-col h4 { font-size: 13px; font-weight: 600; margin-bottom: 1rem; color: #1A1A2E; }
        .footer-col a { display: block; font-size: 13px; color: #888; text-decoration: none; margin-bottom: 6px; }
        .footer-col a:hover { color: #2D6A4F; }
        .footer-bottom { border-top: 1px solid #eee; padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; }
        .footer-bottom p { font-size: 12px; color: #aaa; }
        .footer-bottom-links { display: flex; gap: 1rem; }
        .footer-bottom-links a { font-size: 12px; color: #aaa; text-decoration: none; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('front.home') }}" class="nav-logo">Artisan<span>Hub</span></a>
    <div class="nav-links">
        <a href="{{ route('front.home') }}">Home</a>
        <a href="{{ route('front.products') }}">Shop</a>
        <a href="{{ route('front.teams') }}">Teams</a>
        <a href="{{ route('front.artisans') }}">Artisans</a>
        <a href="{{ route('front.about') }}">About</a>
    </div>
    <div class="nav-search">
        <i class="fas fa-search" style="color:#aaa;font-size:13px;"></i>
        <input type="text" placeholder="Search handcrafted treasures...">
    </div>
    <div class="nav-actions">
    <a href="{{ route('front.wishlist') }}" title="Wishlist"><i class="fas fa-heart"></i></a>
    <a href="{{ route('front.cart') }}" title="Cart"><i class="fas fa-shopping-bag"></i></a>

    @auth('customer')
        <div style="position:relative;" id="profileMenu">
            <div onclick="toggleProfile()" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <div style="width:34px;height:34px;border-radius:50%;background:#E1F5EE;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#2D6A4F;">
                    {{ strtoupper(substr(Auth::guard('customer')->user()->name, 0, 1)) }}
                </div>
            </div>
            <div id="profileDropdown" style="display:none;position:absolute;right:0;top:44px;background:#fff;border:1px solid #eee;border-radius:12px;padding:.5rem;min-width:180px;z-index:999;">
                <div style="padding:.5rem .75rem;border-bottom:1px solid #eee;margin-bottom:.25rem;">
                    <p style="font-size:13px;font-weight:600;margin:0;">{{ Auth::guard('customer')->user()->name }}</p>
                    <p style="font-size:11px;color:#aaa;margin:0;">{{ Auth::guard('customer')->user()->email }}</p>
                </div>
              <a href="{{ route('front.profile') }}" style="...">
                          <i class="fas fa-user" style="width:16px;color:#2D6A4F;"></i> My Profile
                        </a>
                <a href="{{ route('front.orders') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
                    <i class="fas fa-shopping-bag" style="width:16px;color:#2D6A4F;"></i> My Orders
                </a>
                <a href="{{ route('front.bookings') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
                    <i class="fas fa-calendar" style="width:16px;color:#2D6A4F;"></i> My Bookings
                </a>
                <a href="{{ route('front.wishlist') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
                    <i class="fas fa-heart" style="width:16px;color:#2D6A4F;"></i> Wishlist
                </a>
                <div style="border-top:1px solid #eee;margin-top:.25rem;padding-top:.25rem;">
                    <form method="POST" action="{{ route('front.logout') }}">
                        @csrf
                        <button type="submit" style="width:100%;text-align:left;padding:.5rem .75rem;font-size:13px;color:#e74c3c;background:none;border:none;cursor:pointer;border-radius:8px;">
                            <i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('front.login') }}" class="btn-signin">Sign in</a>
    @endauth
</div>
</nav>

@yield('content')

<footer class="footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="nav-logo">Artisan<span>Hub</span></div>
            <p>Connecting artisans with admirers of authentic craftsmanship worldwide.</p>
        </div>
        <div class="footer-col">
            <h4>Shop</h4>
            <a href="{{ route('front.products') }}">All Products</a>
            <a href="{{ route('front.products', ['category' => 'Pottery']) }}">Pottery</a>
            <a href="{{ route('front.products', ['category' => 'Embroidery']) }}">Embroidery</a>
            <a href="{{ route('front.products', ['category' => 'Painting']) }}">Painting</a>
        </div>
        <div class="footer-col">
            <h4>Company</h4>
            <a href="{{ route('front.about') }}">About Us</a>
            <a href="{{ route('front.artisans') }}">Our Artisans</a>
            <a href="#">Careers</a>
            <a href="#">Press</a>
        </div>
        <div class="footer-col">
            <h4>Support</h4>
            <a href="#">Help Center</a>
            <a href="#">Shipping Info</a>
            <a href="#">Returns</a>
            <a href="{{ route('front.contact') }}">Contact</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 ArtisanHub. All rights reserved.</p>
        <div class="footer-bottom-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Cookies</a>
        </div>
    </div>
</footer>

@yield('scripts')

<script>
    function toggleProfile() {
        let d = document.getElementById('profileDropdown');
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('click', function(e) {
        let menu = document.getElementById('profileMenu');
        if (menu && !menu.contains(e.target)) {
            document.getElementById('profileDropdown').style.display = 'none';
        }
    });
</script>
</body>
</html>
