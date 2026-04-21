@extends('cms.parent')
@section('title', 'Edit Notification')
@section('main-title', 'Edit Notification')
@section('sub-title', 'Edit Notification')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Edit Notification</h3></div>
            <form>
                <div class="card-body">

                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" id="users_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($user->id == $notification->users_id) selected @endif>
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" value="{{ $notification->title }}">
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" id="message" rows="3">{{ $notification->message }}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_read"
                                @if($notification->is_read) checked @endif>
                            <label class="custom-control-label" for="is_read">Mark as Read</label>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" onclick="performUpdate({{ $notification->id }})" class="btn btn-primary">Update</button>
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Go To Index</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function performUpdate(id) {
        let formData = new FormData();
        formData.append('users_id', document.getElementById('users_id').value);
        formData.append('title',    document.getElementById('title').value);
        formData.append('message',  document.getElementById('message').value);
        formData.append('is_read',  document.getElementById('is_read').checked ? 1 : 0);
        storeRoute('/cms/Admin/notifications_update/' + id, formData);
    }
</script>
@endsection