 @extends('cms.parent')

@section('main-title' , 'Trashed')
@section('sub-title', 'Trashed')
@section('title', 'trashed')



@section('styles')

@endsection

@section('content')


           <div class="container-fluid">
        <div class="row">


          <div class="col-md-12">



<div class="card-header">

    <div class="card-header">
    <h3 class="card-title">Deleted Admins</h3>
    <div class="card-tools">
        {{-- <button type="button" onclick="confirmForceAll()" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> Empty Trash
        </button> --}}
    </div>
</div>
    <div class="d-flex align-items-center" style="gap: 5px;">

<a href="{{ route('admins.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to index admins
        </a>
              <a href="{{ route('admins.create') }}" class="btn btn-info text-white">
                 <i class="fas fa-plus-circle"></i> Create New admin
          </a>
            <a href="{{ route('admins_forceAll') }}" class="btn btn-danger">
    <i class="fas fa-fire-alt"></i> Empty Trash
</a>
    </div>
</div>


              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 10px">ID</th>
                      <th class="text-center">admin name</th>
                      <th class="text-center">email</th>

                      <th class="text-center" style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($admins as $admin)
                    <tr>

                      <td>{{$admin->id}}</td>
                      <td>{{$admin->name}}</td>
                      <td>{{$admin->email}}</td>

                      <td>
                             <div class="btn-group">

                                 <a href="{{ route('admins_restore'  , $admin->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                             <i class="fas fa-sync" ></i>
                                  </a>

                                  </a>
                             <a href="{{ route('admins_force' , $admin->id ) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
                                   <i class="fas fa-skull-crossbones"></i>
                                  </a>


                                </div>
                    </td>

                    </tr>


                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
        </div>


      </div><!-- /.container-fluid -->




@endsection

@section('scripts')


        <script>


            function performRestore(id) {
        axios.get('/cms/admin/admins_restore/' + id)
            .then(function (response) {
                toastr.success(response.data.title);
                location.reload();
            })
            .catch(function (error) {
                toastr.error(error.response.data.title);
            });
    }

    // 2. الدالة القديمة للحذف الفردي
    function performForceDelete(id, reference) {
        axios.get('/cms/admin/admins_force/' + id)
            .then(function (response) {
                toastr.success(response.data.title);
                reference.closest('tr').remove();
            })
            .catch(function (error) {
                toastr.error(error.response.data.title);
            });
    }

    // 3. الدالة الجديدة (تفريغ السلة) - أضيفيها هنا
    function confirmForceAll() {
        Swal.fire({
            title: 'هل أنتِ متأكدة؟',
            text: "سيتم حذف جميع السجلات في السلة نهائياً!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، فرغ السلة!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // استدعاء الأكسيوس لتنفيذ الحذف للكل
                axios.get('/cms/admin/admins_force_all')
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
            function performDestroy(id , reference){

                 confirmDestroy ('/cms/Admin/admins_force/' +id , reference);
            }



        </script>

@endsection
