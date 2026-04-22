@extends('frontend.layout.app')

@section('title', 'Teams')

@section('styles')
<style>
    .page-header { background: #F8F6F2; padding: 3rem 2rem; border-bottom: 1px solid #eee; text-align: center; }
    .page-header h1 { font-size: 36px; font-weight: 700; margin-bottom: .5rem; }
    .page-header p { font-size: 14px; color: #888; }

    .page-body { max-width: 1200px; margin: 0 auto; padding: 2rem; }

    .teams-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

    .team-card { background: #fff; border: 1px solid #eee; border-radius: 16px; padding: 1.5rem; transition: border-color .2s; }
    .team-card:hover { border-color: #2D6A4F; }

    .team-header { display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; }
    .team-avatar { width: 56px; height: 56px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #2D6A4F; flex-shrink: 0; }
    .team-name { font-size: 16px; font-weight: 700; color: #1A1A2E; margin-bottom: 2px; }
    .team-type { font-size: 12px; color: #aaa; }

    .team-badges { display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap; }
    .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 50px; font-weight: 500; }
    .badge-active { background: #E1F5EE; color: #0F6E56; }
    .badge-verified { background: #E6F1FB; color: #185FA5; }
    .badge-busy { background: #FAEEDA; color: #854F0B; }

    .team-desc { font-size: 13px; color: #666; line-height: 1.6; margin-bottom: 1rem; }

    .team-info { display: flex; gap: 1rem; margin-bottom: 1rem; }
    .team-info-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #888; }
    .team-info-item i { color: #2D6A4F; font-size: 12px; }

    .team-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #eee; padding-top: 1rem; }
    .team-price { font-size: 15px; font-weight: 700; color: #2D6A4F; }
    .team-price span { font-size: 11px; color: #aaa; font-weight: 400; }
    .book-btn { background: #2D6A4F; color: #fff; border: none; padding: 8px 20px; border-radius: 50px; font-size: 13px; cursor: pointer; text-decoration: none; }
    .book-btn:hover { background: #245c43; color: #fff; }

    .no-teams { text-align: center; padding: 4rem; color: #aaa; }
    .no-teams i { font-size: 48px; display: block; margin-bottom: 1rem; }

    .pagination-wrap { display: flex; justify-content: center; margin-top: 2rem; gap: 6px; }
    .pagination-wrap a, .pagination-wrap span { padding: 6px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 13px; text-decoration: none; color: #555; }
    .pagination-wrap .active span { background: #2D6A4F; color: #fff; border-color: #2D6A4F; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h1>Our Teams</h1>
    <p>Book talented teams for your events and celebrations</p>
</div>

<div class="page-body">

    @if($teams->count() > 0)
    <div class="teams-grid">
        @foreach($teams as $team)
        <div class="team-card">
            <div class="team-header">
                <div class="team-avatar">
                    {{ strtoupper(substr($team->team_name, 0, 2)) }}
                </div>
                <div>
                    <div class="team-name">{{ $team->team_name }}</div>
                    <div class="team-type">{{ $team->city->name ?? '' }}</div>
                </div>
            </div>

            <div class="team-badges">
                <span class="badge badge-active">{{ ucfirst($team->status) }}</span>
                @if($team->verification_status == 'verified')
                    <span class="badge badge-verified">Verified</span>
                @endif
            </div>

            <p class="team-desc">{{ Str::limit($team->bio, 100) }}</p>

            <div class="team-info">
                <div class="team-info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $team->city->name ?? 'N/A' }}
                </div>
                <div class="team-info-item">
                    <i class="fas fa-clock"></i>
                    ${{ number_format($team->hourly_rate, 2) }}/hr
                </div>
            </div>

            <div class="team-footer">
                <div class="team-price">
                    ${{ number_format($team->hourly_rate, 2) }}
                    <span>/hour</span>
                </div>
                <a href="{{ route('front.team.show', $team->id) }}" class="book-btn">
                    View & Book
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $teams->links() }}
    </div>

    @else
    <div class="no-teams">
        <i class="fas fa-users"></i>
        <p>No teams available at the moment</p>
    </div>
    @endif

</div>
@endsection
