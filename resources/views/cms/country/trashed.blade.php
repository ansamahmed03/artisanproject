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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Country Table</h3>
              </div>
               <a  href="{{ route('countries.create') }}" type="submit" class="btn btn-primary , ">Create</a>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 10px">ID</th>
                      <th class="text-center">Country name</th>
                      <th class="text-center">Code</th>
                      <th class="text-center">Number of Cities</th>
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

                            <a href="{{ route('countries.show' , $country->id) }}" class="btn btn-sm" style="color: #2ecc71;" title="show">
                             <i class="fas fa-eye"></i>
                              </a>

                               <a href="{{ route('countries.edit' , $country->id ) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                   <i class="fas fa-edit"></i>
                                  </a>

                             <button type="button" onclick="performDestroy({{$country->id  }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
                              <i class="fas fa-trash-alt"></i>
                                </button>
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

                 confirmDestroy ('/cms/Admin/countries/' +id , reference);
            }



        </script>

@endsection
