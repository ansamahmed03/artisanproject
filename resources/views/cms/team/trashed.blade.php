@extends('cms.parent')

@section('main-title' , 'Teams Trash')
@section('sub-title', 'Deleted Teams')
@section('title', 'Teams Trashed')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Deleted Teams</h3>
                </div>

                <div class="card-header border-0">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <a href="{{ route('teams.index', ['guard' => 'Admin']) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Teams
                        </a>
                        <button type="button" onclick="confirmForceAll()" class="btn btn-danger">
                            <i class="fas fa-fire-alt"></i> Empty Trash
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">Team Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center" style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                            <tr>
                                <td class="text-center">{{$team->id}}</td>
                                <td class="text-center">{{$team->team_name}}</td>
                                <td class="text-center">{{$team->email}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" onclick="performRestore({{ $team->id }})" class="btn btn-sm" style="color: #2D6A4F;" title="Restore">
                                            <i class="fas fa-sync"></i>
                                        </button>

                                        <button type="button" onclick="performForceDelete({{ $team->id }}, this)" class="btn btn-sm" style="color: #c0392b;" title="Force Delete">
                                            <i class="fas fa-skull-crossbones"></i>
                                        </button>
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
@endsection

@section('scripts')
<script>
    // 1. استعادة تيم واحد
    function performRestore(id) {
        axios.get('/cms/admin/teams/restore/' + id) // تأكد من المسار في الـ Routes
            .then(function (response) {
                toastr.success(response.data.title);
                location.reload();
            })
            .catch(function (error) {
                toastr.error(error.response.data.title);
            });
    }

    // 2. حذف تيم نهائياً (فردي)
    function performForceDelete(id, reference) {
        confirmDestroy('/cms/admin/teams/force/' + id, reference);
    }

    // 3. تفريغ السلة بالكامل
    function confirmForceAll() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete ALL teams in trash!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Empty Trash!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.get('/cms/admin/teams/force-all')
                    .then(function (response) {
                        toastr.success(response.data.title);
                        location.reload();
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.title);
                    });
            }
        })
    }
</script>
@endsection
