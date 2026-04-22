@extends('frontend.layout.app')

@section('title', 'My Bookings')

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }
    .profile-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }

    .profile-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; text-align: center; margin-bottom: 1rem; }
    .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: #2D6A4F; margin: 0 auto 1rem; }
    .profile-name { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
    .profile-email { font-size: 13px; color: #aaa; margin-bottom: 1rem; }
    .profile-badge { display: inline-block; background: #E1F5EE; color: #0F6E56; font-size: 11px; padding: 4px 12px; border-radius: 50px; }

    .profile-nav { background: #fff; border: 1px solid #eee; border-radius: 16px; overflow: hidden; }
    .profile-nav a { display: flex; align-items: center; gap: 10px; padding: .875rem 1.25rem; font-size: 14px; color: #555; text-decoration: none; border-bottom: 1px solid #eee; }
    .profile-nav a:last-child { border-bottom: none; }
    .profile-nav a:hover { background: #F8F6F2; color: #2D6A4F; }
    .profile-nav a.active { background: #E1F5EE; color: #2D6A4F; font-weight: 600; }
    .profile-nav i { width: 18px; color: #2D6A4F; }

    .content-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; }
    .content-title { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }

    /* Bookings Table */
    .booking-table { width: 100%; border-collapse: collapse; }
    .booking-table th { font-size: 12px; color: #aaa; font-weight: 600; text-align: left; padding: .6rem .75rem; border-bottom: 1px solid #eee; }
    .booking-table td { font-size: 13px; padding: .875rem .75rem; border-bottom: 1px solid #f5f5f5; color: #333; }
    .booking-table tr:last-child td { border-bottom: none; }
    .booking-table tr:hover td { background: #fafafa; }

    /* Status Badge */
    .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }
    .badge-pending  { background: #FFF8E1; color: #F59E0B; }
    .badge-confirmed { background: #E1F5EE; color: #2D6A4F; }
    .badge-cancelled { background: #FFE8E8; color: #e74c3c; }
    .badge-completed { background: #E8F4FF; color: #3B82F6; }

    /* Empty State */
    .empty-state { text-align: center; padding: 3rem 1rem; color: #aaa; }
    .empty-state i { font-size: 48px; display: block; margin-bottom: 1rem; color: #ddd; }
    .empty-state p { font-size: 14px; margin-bottom: 1rem; }
    .btn-browse { display: inline-block; background: #2D6A4F; color: #fff; padding: .6rem 1.5rem; border-radius: 8px; text-decoration: none; font-size: 14px; }
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="profile-grid">

        {{-- Sidebar --}}
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div class="profile-name">{{ $customer->name }}</div>
                <div class="profile-email">{{ $customer->email }}</div>
                <span class="profile-badge">Customer</span>
            </div>

            <div class="profile-nav">
                <a href="{{ route('front.profile') }}">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="#">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="{{ route('front.bookings') }}" class="active">
                    <i class="fas fa-calendar"></i> My Bookings
                </a>
                <a href="{{ route('front.wishlist') }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="profile-content">
            <div class="content-card">
                <div class="content-title">
                    <i class="fas fa-calendar" style="color:#2D6A4F;"></i>
                    My Bookings ({{ $bookings->count() }})
                </div>

                @if($bookings->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>You have no bookings yet!</p>
                        <a href="{{ route('front.teams') }}" class="btn-browse">Browse Teams</a>
                    </div>
                @else
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Team</th>
                                <th>Date</th>
                                <th>Notes</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $i => $booking)
                            <tr>
                                <td style="color:#aaa;">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:600;color:#1A1A2E;">
                                        {{ $booking->team->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td style="color:#888;max-width:200px;">
                                    {{ $booking->notes ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($booking->status) {
                                            'confirmed' => 'badge-confirmed',
                                            'cancelled' => 'badge-cancelled',
                                            'completed' => 'badge-completed',
                                            default     => 'badge-pending',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
