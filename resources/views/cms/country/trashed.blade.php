 @extends('cms.parent')

@section('main-title' , 'Trashed Country')
@section('sub-title', 'Trashed Country')
@section('title', 'trashed Country')



@section('styles')

@endsection

@section('content')


           <div class="container-fluid">
        <div class="row">


          <div class="col-md-12">



<div class="card-header">
    <div class="d-flex align-items-center" style="gap: 5px;">

<a href="{{ route('countries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to index Countries
        </a>
              <a href="{{ route('countries.create') }}" class="btn btn-info text-white">
                 <i class="fas fa-plus-circle"></i> Create New Country
          </a>
            <a href="{{ route('countries_forceAll') }}" class="btn btn-danger">
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
                      <th class="text-center">Country name</th>
                      <th class="text-center">Code</th>

                      <th class="text-center" style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($countries as $country)
                    <tr>

                      <td>{{$country->id}}</td>
                      <td>{{$country->country_name}}</td>
                      <td>{{$country->code}}</td>

                      <td>
                             <div class="btn-group">

                                 <a href="{{ route('countries_restore'  , $country->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                             <i class="fas fa-sync" ></i>
                                  </a>

                                  </a>
                             <a href="{{ route('countries_force' , $country->id ) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
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

                 confirmDestroy ('/cms/Admin/countries_force/' +id , reference);
            }



        </script>

@endsection
