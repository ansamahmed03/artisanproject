@extends('cms.parent')

@section('create-title', 'Create Role')
@section('create', 'Create Role')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Role</h3>
                    </div>

                    <form id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="role_name">Role Name</label>
                                <input type="text" class="form-control" id="role_name" placeholder="مثلاً: admin, writer">
                            </div>

                            <div class="form-group">
                                <label for="guard_name">Guard Name</label>
                                <select class="form-control" id="guard_name" style="width: 100%;">
                                    <option value="admin">Admin</option>
                                    <option value="artisan">Artisan</option>
                                    <option value="customer">Customer</option>
                                    <option value="team">Team</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
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
    function performStore() {
        let formData = new FormData();
        formData.append('name', document.getElementById('role_name').value);
        formData.append('guard_name', document.getElementById('guard_name').value);


        store('/cms/Admin/roles', formData);
    }
</script>
@endsection
