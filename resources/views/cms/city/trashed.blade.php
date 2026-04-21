 @extends('cms.parent')

@section('main-title' , 'Trashed City')
@section('sub-title', 'Trashed City')
@section('title', 'trashed')



@section('styles')

@endsection

@section('content')


           <div class="container-fluid">
        <div class="row">


          <div class="col-md-12">



         <div class="card-header">
                       <div class="d-flex align-items-center" style="gap: 5px;">

              <a href="{{ route('cities.index') }}" class="btn btn-secondary">
                     <i class="fas fa-arrow-left"></i> Back to index Cities
              </a>
              <a href="{{ route('cities.create') }}" class="btn btn-info text-white">
                 <i class="fas fa-plus-circle"></i> Create New City
               </a>
              <a href="{{ route('cities_forceAll') }}" class="btn btn-danger">
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
                                <th class="text-center">City Name</th>
                                <th class="text-center">Street</th>
                                  <th class="text-center">Country Name</th>
                                <th class="text-center" style="width: 150px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($cities as $city)
                    <tr>

                         <td class="text-center">{{ $city->id }}</td>
                                <td class="text-center">{{ $city->name }}</td>
                                <td class="text-center">{{ $city->street }}</td>
                                <td class="text-center">{{ $city->country->country_name ?? 'Deleted City' }}</td>

                      <td>
                             <div class="btn-group">

                                 <a href="{{ route('cities_restore'  ,  $city->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                             <i class="fas fa-sync" ></i>
                                  </a>

                                  </a>
                             <a href="{{ route('cities_force' , $city->id) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
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
            function performDestroy(id , reference){

                 confirmDestroy ('/cms/Admin/cities_force/' +id , reference);
            }



        </script>

@endsection
