@extends('cms.parent')

@section('edit-title', 'Edit permission')
@section('edit', 'Edit permission')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit permission: {{ $permissions->name }}</h3>
                    </div>

                    <form id="edit_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="permission_name">permission Name</label>
                                {{-- هنا وضعنا القيمة القديمة باستخدام value --}}
                                <input type="text" class="form-control" id="permission_name"
                                       value="{{ $permissions->name }}" placeholder="Enter permission Name">
                            </div>

                            <div class="form-group">
    <label for="guard_name">Guard Name</label>
    <select class="form-control" id="guard_name" style="width: 100%;">
        {{-- لاحظي استخدمنا $permission بالمفرد --}}
        <option value="admin" @if($permissions->guard_name == 'admin') selected @endif>Admin</option>
        <option value="artisan" @if($permissions->guard_name == 'artisan') selected @endif>Artisan</option>
        <option value="customer" @if($permissions->guard_name == 'customer') selected @endif>Customer</option>
        <option value="team" @if($permissions->guard_name == 'team') selected @endif>Team</option>
    </select>
</div>
                        </div>

                        <div class="card-footer">
                            {{-- غيرنا اسم الدالة لتعبر عن التحديث --}}
                            <button type="button" onclick="performUpdate({{ $permissions->id }})" class="btn btn-primary">Update permission</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-success">Go To Index</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
   function performUpdate(id) {
    // إرسال كـ Object عادي وليس FormData
    let data = {
        name: document.getElementById('permission_name').value,
        guard_name: document.getElementById('guard_name').value
    };

    // استدعاء دالة التحديث (تأكدي أن دالة update في crud.js تقبل Object)
    axios.put('/cms/Admin/permissions/' + id, data)
        .then(function (response) {
            showMessage(response.data);
        })
        .catch(function (error) {
            showMessage(error.response.data);
        });
}
</script>
@endsection
