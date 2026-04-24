@extends('frontend.layout.app')
@section('title', 'Team Dashboard')

@section('styles')
<style>
    .dash-page { max-width: 1100px; margin: 0 auto; padding: 2rem; }

    /* Header */
    .dash-header { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem 2rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:1rem; }
    .dash-av { width:64px; height:64px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:700; color:#2D6A4F; flex-shrink:0; }
    .dash-name { font-size:22px; font-weight:700; color:#1A1A2E; }
    .dash-sub { font-size:13px; color:#aaa; margin-top:4px; }

    /* Stats */
    .stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:1.5rem; }
    .stat-card { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem; text-align:center; }
    .stat-num { font-size:36px; font-weight:700; }
    .stat-num.green  { color:#2D6A4F; }
    .stat-num.blue   { color:#3498db; }
    .stat-num.yellow { color:#F4A261; }
    .stat-label { font-size:13px; color:#aaa; margin-top:6px; }

    /* Tabs */
    .tabs { display:flex; gap:.5rem; margin-bottom:1.5rem; border-bottom:2px solid #eee; }
    .tab-btn { padding:10px 20px; font-size:14px; font-weight:600; color:#888; background:none; border:none; cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; }
    .tab-btn.active { color:#2D6A4F; border-bottom-color:#2D6A4F; }
    .tab-content { display:none; }
    .tab-content.active { display:block; }

    /* Card */
    .dash-card { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem; margin-bottom:1.5rem; }
    .dash-card-title { font-size:16px; font-weight:700; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #eee; }

    /* Table */
    .dash-table { width:100%; border-collapse:collapse; font-size:13px; }
    .dash-table th { text-align:left; padding:10px 12px; border-bottom:2px solid #eee; font-size:12px; color:#aaa; font-weight:600; }
    .dash-table td { padding:10px 12px; border-bottom:1px solid #f5f5f5; color:#444; vertical-align:middle; }

    /* Badges */
    .badge { display:inline-block; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:600; }
    .badge-pending   { background:#FFF3CD; color:#856404; }
    .badge-confirmed { background:#D1FAE5; color:#065F46; }
    .badge-completed { background:#D1FAE5; color:#065F46; }
    .badge-cancelled { background:#FEE2E2; color:#991B1B; }
    .badge-active    { background:#D1FAE5; color:#065F46; }
    .badge-inactive  { background:#F3F4F6; color:#6B7280; }

    /* Info Card */
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .info-item { background:#F8F6F2; border-radius:10px; padding:1rem; }
    .info-label { font-size:11px; color:#aaa; font-weight:600; margin-bottom:4px; }
    .info-value { font-size:14px; font-weight:600; color:#1A1A2E; }

    /* Empty */
    .empty-msg { text-align:center; padding:2.5rem; color:#aaa; font-size:13px; }
    .empty-msg i { font-size:36px; color:#ddd; display:block; margin-bottom:.5rem; }

    /* Alerts */
    .alert-success { background:#D1FAE5; border:1px solid #6EE7B7; color:#065F46; padding:10px 16px; border-radius:10px; margin-bottom:1rem; font-size:13px; }
    .alert-error   { background:#FEE2E2; border:1px solid #FCA5A5; color:#991B1B; padding:10px 16px; border-radius:10px; margin-bottom:1rem; font-size:13px; }
</style>
@endsection

@section('content')
<div class="dash-page">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="dash-header">
        <div class="dash-av">{{ strtoupper(substr($team->team_name, 0, 2)) }}</div>
        <div>
            <div class="dash-name">{{ $team->team_name }}</div>
            <div class="dash-sub">
                <i class="fas fa-map-marker-alt" style="color:#2D6A4F;font-size:11px;"></i>
                {{ $team->city->name ?? '—' }}
                &nbsp;·&nbsp;
                <i class="fas fa-clock" style="color:#2D6A4F;font-size:11px;"></i>
                ${{ number_format($team->hourly_rate, 2) }}/hr
                &nbsp;·&nbsp;
                <span class="badge badge-{{ $team->status ?? 'active' }}">
                    {{ ucfirst($team->status ?? 'active') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num green">{{ $bookings->count() }}</div>
            <div class="stat-label"><i class="fas fa-calendar"></i> Total Bookings</div>
        </div>
        <div class="stat-card">
            <div class="stat-num blue">
                {{ $bookings->where('status', 'confirmed')->count() }}
            </div>
            <div class="stat-label"><i class="fas fa-check-circle"></i> Confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-num yellow">
                {{ $bookings->where('status', 'pending')->count() }}
            </div>
            <div class="stat-label"><i class="fas fa-clock"></i> Pending</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('bookings', event)">
            <i class="fas fa-calendar"></i> Bookings
        </button>
        <button class="tab-btn" onclick="switchTab('info', event)">
            <i class="fas fa-info-circle"></i> My Info
        </button>
    </div>

    {{-- ===== Tab: Bookings ===== --}}
    <div id="tab-bookings" class="tab-content active">
        <div class="dash-card">
            <div class="dash-card-title">
                All Bookings ({{ $bookings->count() }})
            </div>

            @if($bookings->isEmpty())
                <div class="empty-msg">
                    <i class="fas fa-calendar-times"></i>
                    No bookings yet.
                </div>
            @else
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $booking->customer->name ?? '—' }}</div>
                                <div style="font-size:11px;color:#aaa;">{{ $booking->customer->email ?? '' }}</div>
                            </td>
                            <td>
                                {{ $booking->booking_date
                                    ? \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y')
                                    : $booking->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $booking->status ?? 'pending' }}">
                                    {{ ucfirst($booking->status ?? 'pending') }}
                                </span>
                            </td>
                            <td style="color:#888;">{{ $booking->notes ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- ===== Tab: My Info ===== --}}
    <div id="tab-info" class="tab-content">
        <div class="dash-card">
            <div class="dash-card-title">My Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">TEAM NAME</div>
                    <div class="info-value">{{ $team->team_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">CITY</div>
                    <div class="info-value">{{ $team->city->name ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">HOURLY RATE</div>
                    <div class="info-value">${{ number_format($team->hourly_rate, 2) }}/hr</div>
                </div>
                <div class="info-item">
                    <div class="info-label">STATUS</div>
                    <div class="info-value">
                        <span class="badge badge-{{ $team->status ?? 'active' }}">
                            {{ ucfirst($team->status ?? 'active') }}
                        </span>
                    </div>
                </div>
                @if($team->bio)
                <div class="info-item" style="grid-column:1/-1;">
                    <div class="info-label">BIO</div>
                    <div class="info-value" style="font-weight:400;line-height:1.6;">{{ $team->bio }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function switchTab(name, e) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    e.currentTarget.classList.add('active');
}
</script>
@endsection
