@extends('cms.parent')
@section('title', 'Show Notification')
@section('main-title', 'Show Notification')
@section('sub-title', 'Show Notification')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Notification Details</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label>User</label>
                    <input type="text" class="form-control" disabled value="{{ $notification->user->email ?? '-' }}">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" disabled value="{{ $notification->title }}">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" disabled rows="3">{{ $notification->message }}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" disabled value="{{ $notification->is_read ? 'Read' : 'Unread' }}">
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Go To Index
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
