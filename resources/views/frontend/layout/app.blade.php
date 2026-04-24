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

@php
    $notifCount = 0;
    $notifs = collect();

    if (Auth::guard('customer')->check()) {
        $notifs = Auth::guard('customer')->user()->notifications()->latest()->take(5)->get();
        $notifCount = Auth::guard('customer')->user()->notifications()->where('is_read', 0)->count();
    } elseif (Auth::guard('artisan')->check()) {
        $notifs = Auth::guard('artisan')->user()->notifications()->latest()->take(5)->get();
        $notifCount = Auth::guard('artisan')->user()->notifications()->where('is_read', 0)->count();
    } elseif (Auth::guard('team')->check()) {
        $notifs = Auth::guard('team')->user()->notifications()->latest()->take(5)->get();
        $notifCount = Auth::guard('team')->user()->notifications()->where('is_read', 0)->count();
    }
@endphp

<nav class="navbar">
    <a href="{{ route('front.home') }}" class="nav-logo">Artisan<span>Hub</span></a>

    <div class="nav-links">
        <a href="{{ route('front.home') }}">Home</a>
        <a href="{{ route('front.products') }}">Shop</a>
        <a href="{{ route('front.teams') }}">Teams</a>
        <a href="{{ route('front.artisans') }}">Artisans</a>
        <a href="{{ route('front.about') }}">About</a>
    </div>

    <form action="{{ route('front.search') }}" method="GET" class="nav-search">
        <i class="fas fa-search" style="color:#aaa;font-size:13px;"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search handcrafted treasures..." autocomplete="off">
    </form>

    {{-- ===== nav-actions: كل الأيقونات هون ===== --}}
    <div class="nav-actions">

        {{-- Wishlist --}}
        <a href="{{ route('front.wishlist') }}" title="Wishlist"><i class="fas fa-heart"></i></a>

        {{-- Cart --}}
        <a href="{{ route('front.cart') }}" title="Cart"><i class="fas fa-shopping-bag"></i></a>

        {{-- Bell - Notifications --}}
        <div style="position:relative;" id="notifMenu">
            <div onclick="toggleNotif()" style="cursor:pointer;position:relative;display:flex;align-items:center;">
                <i class="fas fa-bell" style="font-size:18px;color:#555;"></i>
                @if($notifCount > 0)
                    <span style="position:absolute;top:-6px;right:-6px;background:#e74c3c;color:#fff;font-size:10px;font-weight:700;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        {{ $notifCount > 9 ? '9+' : $notifCount }}
                    </span>
                @endif
            </div>

            <div id="notifDropdown" style="display:none;position:absolute;right:0;top:44px;background:#fff;border:1px solid #eee;border-radius:12px;width:300px;z-index:999;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                <div style="padding:.75rem 1rem;border-bottom:1px solid #eee;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:14px;font-weight:700;">Notifications</span>
                    @if($notifCount > 0)
                        <form method="POST" action="{{ route('notifications.markAllRead') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="font-size:11px;color:#2D6A4F;background:none;border:none;cursor:pointer;">Mark all read</button>
                        </form>
                    @endif
                </div>

                @if($notifs->isEmpty())
                    <div style="padding:1.5rem;text-align:center;color:#aaa;font-size:13px;">
                        <i class="fas fa-bell-slash" style="font-size:24px;display:block;margin-bottom:.5rem;color:#ddd;"></i>
                        No notifications
                    </div>
                @else
                    @foreach($notifs as $notif)
                    <div style="padding:.75rem 1rem;border-bottom:1px solid #f5f5f5;background:{{ $notif->is_read ? '#fff' : '#F0FFF8' }};">
                        <form method="POST" action="{{ route('notifications.markRead', $notif->id) }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:0;">
                                <div style="font-size:13px;font-weight:{{ $notif->is_read ? '400' : '600' }};color:#1A1A2E;">{{ $notif->title }}</div>
                                <div style="font-size:12px;color:#888;margin-top:2px;">{{ $notif->message }}</div>
                                <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $notif->created_at->diffForHumans() }}</div>
                            </button>
                        </form>
                    </div>
                    @endforeach
                    <div style="padding:.75rem 1rem;text-align:center;">
                        <a href="{{ route('notifications.index') }}" style="font-size:12px;color:#2D6A4F;text-decoration:none;font-weight:600;">View all notifications</a>
                    </div>
                @endif
            </div>
        </div>
        {{-- END Bell --}}

        {{-- Profile / Sign in --}}
        @auth('customer')
            <div style="position:relative;" id="profileMenu">
                <div onclick="toggleProfile()" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <div style="width:34px;height:34px;border-radius:50%;background:#E1F5EE;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#2D6A4F;">
                        {{ strtoupper(substr(Auth::guard('customer')->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div id="profileDropdown" style="display:none;position:absolute;right:0;top:44px;background:#fff;border:1px solid #eee;border-radius:12px;padding:.5rem;min-width:180px;z-index:999;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <div style="padding:.5rem .75rem;border-bottom:1px solid #eee;margin-bottom:.25rem;">
                        <p style="font-size:13px;font-weight:600;margin:0;">{{ Auth::guard('customer')->user()->name }}</p>
                        <p style="font-size:11px;color:#aaa;margin:0;">{{ Auth::guard('customer')->user()->email }}</p>
                    </div>
                    <a href="{{ route('front.profile') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
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

        @elseauth('artisan')
            <div style="position:relative;" id="profileMenu">
                <div onclick="toggleProfile()" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <div style="width:34px;height:34px;border-radius:50%;background:#E1F5EE;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#2D6A4F;">
                        {{ strtoupper(substr(Auth::guard('artisan')->user()->artisan_name, 0, 1)) }}
                    </div>
                </div>
                <div id="profileDropdown" style="display:none;position:absolute;right:0;top:44px;background:#fff;border:1px solid #eee;border-radius:12px;padding:.5rem;min-width:180px;z-index:999;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <div style="padding:.5rem .75rem;border-bottom:1px solid #eee;margin-bottom:.25rem;">
                        <p style="font-size:13px;font-weight:600;margin:0;">{{ Auth::guard('artisan')->user()->artisan_name }}</p>
                        <p style="font-size:11px;color:#aaa;margin:0;">{{ Auth::guard('artisan')->user()->email }}</p>
                    </div>
                    <a href="{{ route('artisan.dashboard') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
                        <i class="fas fa-tachometer-alt" style="width:16px;color:#2D6A4F;"></i> My Dashboard
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

        @elseauth('team')
            <div style="position:relative;" id="profileMenu">
                <div onclick="toggleProfile()" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <div style="width:34px;height:34px;border-radius:50%;background:#E1F5EE;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#2D6A4F;">
                        {{ strtoupper(substr(Auth::guard('team')->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div id="profileDropdown" style="display:none;position:absolute;right:0;top:44px;background:#fff;border:1px solid #eee;border-radius:12px;padding:.5rem;min-width:180px;z-index:999;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <div style="padding:.5rem .75rem;border-bottom:1px solid #eee;margin-bottom:.25rem;">
                        <p style="font-size:13px;font-weight:600;margin:0;">{{ Auth::guard('team')->user()->name }}</p>
                        <p style="font-size:11px;color:#aaa;margin:0;">{{ Auth::guard('team')->user()->email }}</p>
                    </div>
                    <a href="{{ route('team.dashboard') }}" style="display:block;padding:.5rem .75rem;font-size:13px;color:#555;text-decoration:none;border-radius:8px;">
                        <i class="fas fa-tachometer-alt" style="width:16px;color:#2D6A4F;"></i> My Dashboard
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
    {{-- END nav-actions --}}

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
            <a href="{{ route('front.teams') }}">Our Teams</a>
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

{{-- ===== Single Script Block ===== --}}
<script>
    function toggleNotif() {
        let d = document.getElementById('notifDropdown');
        let p = document.getElementById('profileDropdown');
        if (p) p.style.display = 'none';
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }

    function toggleProfile() {
        let d = document.getElementById('profileDropdown');
        let n = document.getElementById('notifDropdown');
        if (n) n.style.display = 'none';
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('click', function(e) {
        let notifMenu = document.getElementById('notifMenu');
        let profileMenu = document.getElementById('profileMenu');

        if (notifMenu && !notifMenu.contains(e.target)) {
            let nd = document.getElementById('notifDropdown');
            if (nd) nd.style.display = 'none';
        }
        if (profileMenu && !profileMenu.contains(e.target)) {
            let pd = document.getElementById('profileDropdown');
            if (pd) pd.style.display = 'none';
        }
    });
</script>
</body>
</html>
