@extends('cms.parent')

@section('main-title' , 'Roles')
@section('sub-title', 'Index Roles')
@section('title', 'Index Roles')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- رابط إنشاء دور جديد --}}
                    <a href="{{ route('roles.create') }}" class="btn btn-info" style="color: white;">
                        <i class="fas fa-plus-circle"></i> Create New Role
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">Role Name</th>
                                <th class="text-center">Guard Name</th>
                                <th>Permissions</th> <th>Setting</th>
                                <th class="text-center" style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="text-center">{{ $role->id }}</td>
                                <td class="text-center">{{ $role->name }}</td>
                                <td><span class="badge bg-success">{{ $role->guard_name }}</span></td>

    <td>
        <a href="{{ route('roles.permissions.index', $role->id) }}" class="btn btn-info">
            ({{ $role->permissions_count }}) permissions/s
        </a>
    </td>
                                <td class="text-center">
                                    {{-- عرض الجارد بشكل جمالي (Badge) --}}
                                    <span class="badge bg-primary px-3 py-2">{{ $role->guard_name }}</span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- زر التعديل --}}
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- زر الحذف --}}
                                        <button type="button" onclick="performDestroy({{$role->id}}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{-- روابط الترقيم التلقائي --}}
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        // تم تغيير الرابط ليوجه إلى الـ Roles Controller
        confirmDestroy('/cms/Admin/roles/' + id, reference);
    }
</script>
@endsection
