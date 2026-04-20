@extends('cms.parent')

@section('edit-title', 'Edit Role')
@section('edit', 'Edit Role')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Role: {{ $roles->name }}</h3>
                    </div>

                    <form id="edit_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="role_name">Role Name</label>
                                {{-- هنا وضعنا القيمة القديمة باستخدام value --}}
                                <input type="text" class="form-control" id="role_name"
                                       value="{{ $roles->name }}" placeholder="Enter Role Name">
                            </div>

                            <div class="form-group">
    <label for="guard_name">Guard Name</label>
    <select class="form-control" id="guard_name" style="width: 100%;">
        {{-- لاحظي استخدمنا $role بالمفرد --}}
        <option value="admin" @if($roles->guard_name == 'admin') selected @endif>Admin</option>
        <option value="artisan" @if($roles->guard_name == 'artisan') selected @endif>Artisan</option>
        <option value="customer" @if($roles->guard_name == 'customer') selected @endif>Customer</option>
        <option value="team" @if($roles->guard_name == 'team') selected @endif>Team</option>
    </select>
</div>
                        </div>

                        <div class="card-footer">
                            {{-- غيرنا اسم الدالة لتعبر عن التحديث --}}
                            <button type="button" onclick="performUpdate({{ $roles->id }})" class="btn btn-primary">Update Role</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-success">Go To Index</a>
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
        name: document.getElementById('role_name').value,
        guard_name: document.getElementById('guard_name').value
    };

    // استدعاء دالة التحديث (تأكدي أن دالة update في crud.js تقبل Object)
    axios.put('/cms/Admin/roles/' + id, data)
        .then(function (response) {
            showMessage(response.data);
        })
        .catch(function (error) {
            showMessage(error.response.data);
        });
}
</script>
@endsection
