@extends('cms.parent')

@section('title', 'Role Permissions')
@section('main-title', 'Role Permissions')
@section('small-title', 'Role Permissions')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Role Permissions</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td><span class="badge bg-info">{{ $permission->guard_name }}</span></td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="permission_{{ $permission->id }}"
                                               onchange="storeRolePermission({{ $role->id }}, {{ $permission->id }})"
                                                @if($permission->assigned) checked @endif>
                                            <label for="permission_{{ $permission->id }}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
function storeRolePermission(roleId, permissionId) {
    axios.post('/cms/Admin/roles/' + roleId + '/permissions', {
        permission_id: permissionId // نرسل فقط ID الصلاحية لأن الـ Role ID موجود في الرابط
    })
    .then(function (response) {
        // عرض رسالة النجاح كما تظهر عند الدكتور
        toastr.success(response.data.title);
    })
    .catch(function (error) {
        // عرض رسالة الخطأ في حال فشل الطلب
        toastr.error(error.response.data.message);
    });
}
</script>
@endsection
