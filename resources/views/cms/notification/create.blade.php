@extends('cms.parent')
@section('title', 'Create Notification')
@section('main-title', 'Create Notification')
@section('sub-title', 'Create Notification')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Create Notification</h3></div>
            <form>
                <div class="card-body">

                    {{-- نوع المستلم --}}
                    <div class="form-group">
                        <label>Recipient Type</label>
                        <select class="form-control" id="notifiable_type" onchange="loadRecipients()">
                            <option value="">-- Select Type --</option>
                            <option value="customer">Customer</option>
                            <option value="artisan">Artisan</option>
                            <option value="team">Team</option>
                        </select>
                    </div>

                    {{-- المستلم --}}
                    <div class="form-group">
                        <label>Recipient</label>
                        <select class="form-control" id="notifiable_id">
                            <option value="">-- Select Recipient --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Notification title">
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" id="message" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_read">
                            <label class="custom-control-label" for="is_read">Mark as Read</label>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" onclick="performStore()" class="btn btn-primary">Send</button>
                    <a href="{{ route('notifications.index') }}" class="btn btn-info">Go To Index</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function loadRecipients() {
        let type = document.getElementById('notifiable_type').value;
        let select = document.getElementById('notifiable_id');
        select.innerHTML = '<option value="">-- Select Recipient --</option>';

        if (!type) return;

        fetch('/cms/Admin/notifications-recipients/' + type)
            .then(res => res.json())
            .then(data => {
                data.forEach(item => {
                    select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            });
    }

    function performStore() {
        let formData = new FormData();
        formData.append('notifiable_type', document.getElementById('notifiable_type').value);
        formData.append('notifiable_id',   document.getElementById('notifiable_id').value);
        formData.append('title',           document.getElementById('title').value);
        formData.append('message',         document.getElementById('message').value);
        formData.append('is_read',         document.getElementById('is_read').checked ? 1 : 0);
        store('/cms/Admin/notifications', formData);
    }
</script>
@endsection