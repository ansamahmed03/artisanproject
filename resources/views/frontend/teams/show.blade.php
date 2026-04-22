@extends('frontend.layout.app')

@section('title', $team->team_name)

@section('styles')
<style>
    .page-body { max-width: 1100px; margin: 0 auto; padding: 2rem; }

    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #aaa; margin-bottom: 2rem; }
    .breadcrumb a { color: #aaa; text-decoration: none; }
    .breadcrumb a:hover { color: #2D6A4F; }

    .team-top { display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; margin-bottom: 3rem; }

    .team-card-left { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 2rem; text-align: center; }
    .team-avatar-big { width: 100px; height: 100px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: #2D6A4F; margin: 0 auto 1rem; }
    .team-title { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
    .team-location { font-size: 13px; color: #888; margin-bottom: 1rem; }
    .team-badges { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 50px; font-weight: 500; }
    .badge-active { background: #E1F5EE; color: #0F6E56; }
    .badge-verified { background: #E6F1FB; color: #185FA5; }
    .team-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.5rem; }
    .stat-box { background: #F8F6F2; border-radius: 10px; padding: .75rem; text-align: center; }
    .stat-num { font-size: 18px; font-weight: 700; color: #2D6A4F; }
    .stat-label { font-size: 11px; color: #aaa; }
    .price-big { font-size: 28px; font-weight: 700; color: #2D6A4F; margin-bottom: 4px; }
    .price-label { font-size: 12px; color: #aaa; margin-bottom: 1.5rem; }

    .team-card-right { }
    .section-title { font-size: 18px; font-weight: 700; margin-bottom: 1rem; }
    .team-bio { font-size: 14px; color: #666; line-height: 1.7; margin-bottom: 2rem; }

    .booking-form { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; }
    .booking-form h3 { font-size: 16px; font-weight: 700; margin-bottom: 1.25rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #444; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 14px; border: 1px solid #eee; border-radius: 10px; font-size: 13px; outline: none; }
    .form-group input:focus, .form-group textarea:focus { border-color: #2D6A4F; }
    .submit-btn { width: 100%; background: #2D6A4F; color: #fff; border: none; padding: 12px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .submit-btn:hover { background: #245c43; }
    .login-msg { text-align: center; padding: 1rem; background: #F8F6F2; border-radius: 10px; font-size: 13px; color: #666; }
    .login-msg a { color: #2D6A4F; font-weight: 600; text-decoration: none; }
</style>
@endsection

@section('content')
<div class="page-body">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('front.home') }}">Home</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <a href="{{ route('front.teams') }}">Teams</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <span>{{ $team->team_name }}</span>
    </div>

    <div class="team-top">

        {{-- Left --}}
        <div class="team-card-left">
            <div class="team-avatar-big">
                {{ strtoupper(substr($team->team_name, 0, 2)) }}
            </div>
            <div class="team-title">{{ $team->team_name }}</div>
            <div class="team-location">
                <i class="fas fa-map-marker-alt" style="color:#2D6A4F"></i>
                {{ $team->city->name ?? 'N/A' }}
            </div>
            <div class="team-badges">
                <span class="badge badge-active">{{ ucfirst($team->status) }}</span>
                @if($team->verification_status == 'verified')
                    <span class="badge badge-verified">Verified</span>
                @endif
            </div>
            <div class="team-stats">
                <div class="stat-box">
                    <div class="stat-num">{{ $team->bookings->count() }}</div>
                    <div class="stat-label">Bookings</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num">
                        {{ $team->verification_status == 'verified' ? '✓' : '—' }}
                    </div>
                    <div class="stat-label">Verified</div>
                </div>
            </div>
            <div class="price-big">${{ number_format($team->hourly_rate, 2) }}</div>
            <div class="price-label">per hour</div>
        </div>

        {{-- Right --}}
        <div class="team-card-right">
            <h2 class="section-title">About the team</h2>
            <p class="team-bio">{{ $team->bio ?? 'No description available.' }}</p>

            {{-- Booking Form --}}
            <div class="booking-form">
                <h3>Book this team</h3>

                <div class="form-group">
                    <label>Booking Date</label>
                    <input type="date" id="booking_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>

                <div class="form-group">
                    <label>Notes (optional)</label>
                    <textarea id="notes" rows="3" placeholder="Any special requests..."></textarea>
                </div>

                <button class="submit-btn" onclick="performBooking({{ $team->id }})">
                    <i class="fas fa-calendar-check"></i> Confirm Booking
                </button>
                {{-- بعد الـ booking form --}}
@if($team->bookings->count() > 0)
<div style="margin-top:1.5rem;padding:1rem;background:#F8F6F2;border-radius:12px;">
    <h4 style="font-size:14px;font-weight:600;margin-bottom:10px;">Booked Dates</h4>
    @foreach($team->bookings->where('status','!=','cancelled') as $booking)
    <span style="display:inline-block;background:#fff;border:1px solid #eee;padding:4px 10px;border-radius:50px;font-size:12px;margin:3px;">
        {{ $booking->booking_date }}
    </span>
    @endforeach
</div>
@endif
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
    function performBooking(teamId) {
        let date  = document.getElementById('booking_date').value;
        let notes = document.getElementById('notes').value;

        if (!date) {
            alert('Please select a booking date!');
            return;
        }

        fetch('/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                team_id:      teamId,
                booking_date: date,
                notes:        notes
            })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.title);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        });
    }
</script>
@endsection
