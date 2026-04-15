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
    <h3 class="card-title">Deleted artisans</h3>
    <div class="card-tools">
        {{-- <button type="button" onclick="confirmForceAll()" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> Empty Trash
        </button> --}}
    </div>
</div>
    <div class="d-flex align-items-center" style="gap: 5px;">

<a href="{{ route('artisans.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to index artisans
        </a>
              <a href="{{ route('artisans.create') }}" class="btn btn-info text-white">
                 <i class="fas fa-plus-circle"></i> Create New artisan
          </a>
            <a href="{{ route('artisans_forceAll') }}" class="btn btn-danger">
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
                      <th class="text-center">artisan name</th>
                      <th class="text-center">store name</th>

                      <th class="text-center" style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($artisans as $artisan)
                    <tr>

                      <td>{{$artisan->id}}</td>
                      <td>{{$artisan->name}}</td>
                      <td>{{$artisan->store_name}}</td>

                      <td>
                             <div class="btn-group">

                                 <a href="{{ route('artisans_restore'  , $artisan->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                             <i class="fas fa-sync" ></i>
                                  </a>

                                  </a>
                             <a href="{{ route('artisans_force' , $artisan->id ) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
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
        axios.get('/cms/artisan/artisans_restore/' + id)
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
        axios.get('/cms/artisan/artisans_force/' + id)
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
                axios.get('/cms/artisan/artisans_force_all')
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

                 confirmDestroy ('/cms/artisan/artisans_force/' +id , reference);
            }



        </script>

@endsection
