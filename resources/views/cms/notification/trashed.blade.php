@extends('cms.parent')
@section('title', 'Trashed Notifications')
@section('main-title', 'Trashed Notifications')
@section('sub-title', 'Trashed Notifications')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex" style="gap:5px;">
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="{{ route('notifications_forceAll') }}" class="btn btn-danger"><i class="fas fa-fire-alt"></i> Empty Trash</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Deleted At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                 <tbody>
    @foreach($notifications as $notification)
    <tr>
        <td class="text-center">{{ $notification->id }}</td>
        <td class="text-center">
            @if($notification->notifiable)
                <strong>{{ $notification->notifiable->name ?? $notification->notifiable->artisan_name ?? $notification->notifiable->team_name }}</strong>
                <br>
                <small class="text-muted">{{ class_basename($notification->notifiable_type) }}</small>
            @else
                <span class="text-danger">Deleted User</span>
            @endif
        </td>
        <td class="text-center">{{ $notification->title }}</td>
        <td class="text-center">{{ $notification->deleted_at->format('Y-m-d H:i') }}</td>
        <td class="text-center">
            <div class="btn-group">
                {{-- زر الاستعادة --}}
                <a href="{{ route('notifications_restore', $notification->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="Restore">
                    <i class="fas fa-sync"></i>
                </a>

                {{-- زر الحذف النهائي --}}
                <a href="{{ route('notifications_force', $notification->id) }}" class="btn btn-sm" style="color: #c0392b;" title="Force Delete">
                    <i class="fas fa-skull-crossbones"></i>
                </a>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')


        <script>
            function performDestroy(id , reference){

                 confirmDestroy ('/cms/Admin/notifications_force/' +id , reference);
            }



        </script>

@endsection
