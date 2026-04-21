@extends('cms.parent')
@section('title', 'Notifications')
@section('main-title', 'Index Notifications')
@section('sub-title', 'Index Notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('notifications.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Notification
                    </a>
                    <a href="{{ route('notifications_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">ID</th>
                                <th class="text-center">Recipient</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Message</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                            <tr>
                                <td class="text-center">{{ $notification->id }}</td>
                                <td class="text-center">
                                    {{-- التعديل هنا لضمان عرض الاسم حتى لو كان محذوفاً سوفت دليت --}}
                                    @if($notification->notifiable)
                                        <span class="font-weight-bold">
                                            {{ $notification->notifiable->name ?? $notification->notifiable->artisan_name ?? $notification->notifiable->team_name }}
                                        </span>
                                    @else
                                        <span class="text-danger italic">Deleted User</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ class_basename($notification->notifiable_type) }}</small>
                                </td>
                                <td class="text-center">{{ $notification->title }}</td>
                                <td class="text-center">{{ Str::limit($notification->message, 40) }}</td>
                                <td class="text-center">
                                    @if($notification->is_read)
                                        <span class="badge badge-success">Read</span>
                                    @else
                                        <span class="badge badge-warning">Unread</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('notifications.show', $notification->id) }}" class="btn btn-sm" style="color:#2ecc71;" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-sm" style="color:#3498db;" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button onclick="performDestroy({{ $notification->id }}, this)" class="btn btn-sm" style="color:#e74c3c;" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/notifications/' + id, reference);
    }
</script>
@endsection
@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/notifications/' + id, reference);
    }
</script>
@endsection