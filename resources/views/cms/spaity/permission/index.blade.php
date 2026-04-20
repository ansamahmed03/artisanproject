@extends('cms.parent')

@section('main-title' , 'Permissions')
@section('sub-title', 'Index Permissions')
@section('title', 'Index permissions')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- رابط إنشاء دور جديد --}}
                    <a href="{{ route('permissions.create') }}" class="btn btn-info" style="color: white;">
                        <i class="fas fa-plus-circle"></i> Create New permission
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">permission Name</th>
                                <th class="text-center">Guard Name</th>
                                <th class="text-center" style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td class="text-center">{{ $permission->id }}</td>
                                <td class="text-center">{{ $permission->name }}</td>
                                <td class="text-center">
                                    {{-- عرض الجارد بشكل جمالي (Badge) --}}
                                    <span class="badge bg-primary px-3 py-2">{{ $permission->guard_name }}</span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- زر التعديل --}}
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- زر الحذف --}}
                                        <button type="button" onclick="performDestroy({{$permission->id}}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
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
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        // تم تغيير الرابط ليوجه إلى الـ permissions Controller
        confirmDestroy('/cms/Admin/permissions/' + id, reference);
    }
</script>
@endsection
