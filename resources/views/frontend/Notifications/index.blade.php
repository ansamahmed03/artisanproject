@extends('frontend.layout.app')
@section('title', 'Notifications')

@section('styles')
<style>
    .notif-page { max-width: 700px; margin: 0 auto; padding: 2rem; }
    .notif-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .notif-header h1 { font-size:22px; font-weight:700; }

    .notif-card { background:#fff; border:1px solid #eee; border-radius:12px; margin-bottom:.75rem; overflow:hidden; transition:box-shadow .2s; }
    .notif-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.06); }
    .notif-card.unread { border-left:3px solid #2D6A4F; background:#F0FFF8; }

    .notif-body { padding:1rem 1.25rem; display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; }
    .notif-icon { width:38px; height:38px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .notif-icon i { color:#2D6A4F; font-size:14px; }
    .notif-content { flex:1; }
    .notif-title { font-size:14px; font-weight:600; color:#1A1A2E; margin-bottom:3px; }
    .notif-msg { font-size:13px; color:#666; line-height:1.5; }
    .notif-time { font-size:11px; color:#aaa; margin-top:5px; }
    .notif-actions { display:flex; gap:.5rem; flex-shrink:0; }
    .btn-read { background:none; border:1px solid #2D6A4F; color:#2D6A4F; padding:4px 12px; border-radius:50px; font-size:11px; cursor:pointer; }
    .btn-read:hover { background:#2D6A4F; color:#fff; }

    .empty-msg { text-align:center; padding:4rem; color:#aaa; }
    .empty-msg i { font-size:48px; color:#ddd; display:block; margin-bottom:1rem; }

    .btn-mark-all { background:#E1F5EE; color:#2D6A4F; border:none; padding:8px 18px; border-radius:50px; font-size:13px; font-weight:600; cursor:pointer; }
    .btn-mark-all:hover { background:#2D6A4F; color:#fff; }

    .alert-success { background:#D1FAE5; border:1px solid #6EE7B7; color:#065F46; padding:10px 16px; border-radius:10px; margin-bottom:1rem; font-size:13px; }
</style>
@endsection

@section('content')
<div class="notif-page">

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="notif-header">
        <h1><i class="fas fa-bell" style="color:#2D6A4F;"></i> Notifications</h1>
        @if($notifications->where('is_read', 0)->count() > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button type="submit" class="btn-mark-all">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="empty-msg">
            <i class="fas fa-bell-slash"></i>
            <p>No notifications yet</p>
        </div>
    @else
        @foreach($notifications as $notif)
        <div class="notif-card {{ $notif->is_read ? '' : 'unread' }}">
            <div class="notif-body">
                <div class="notif-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="notif-content">
                    <div class="notif-title">{{ $notif->title }}</div>
                    <div class="notif-msg">{{ $notif->message }}</div>
                    <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
                @if(!$notif->is_read)
                <div class="notif-actions">
                    <form method="POST" action="{{ route('notifications.markRead', $notif->id) }}">
                        @csrf
                        <button type="submit" class="btn-read">Mark read</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    @endif

</div>
@endsection
