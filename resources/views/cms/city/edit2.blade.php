@extends('cms.parent')

@section('create-title' , 'Create City')
@section('create', 'Create City')
@section('create', 'Create City')



@section('styles')

@endsection

@section('content')
 <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div  class="card-body">
                  <div   class="form-group">
                    <label for="name">City Name</label>
                    <input  type="text"
                    class="form-control"
                     id="name"
                     name="name"
                     value="{{ $cities->City_name }}"
                     placeholder="Enter City Name">


                  </div>
                  <div  class="form-group">
                    <label for="street">street</label>
                    <input type="text"
                     class="form-control"
                     id="street"
                     name="street"
                     value="{{ $cities->street }}"
                   placeholder="Enter street">
                  </div>


                  </div> <!-- -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="botton" onclick="performUpdate({{ $cities->id }})" class="btn btn-primary">Update</button>
                   <a  href="{{ route('cities.index') }}" type="submit" class="btn btn-primary">GO Back</a>
                </div>


              </form>
            </div>
            <!-- /.card -->

            <!-- general form elements -->
            <div class="card card-primary">


            </div>
            <!-- /.card -->



            <!-- /.card -->

          </div>

        </div>
        <!-- /.row -->
      </div


@endsection

@section('scripts')

      <script>

        function performUpdate (id){
           let formData = new FormData();
             formData.append('City_name',document.getElementById('City_name').value);
             formData.append('street',document.getElementById('street').value);

                     storeRoute('/cms/Admin/cities_update/'+id ,formData)



        }






      </script>

@endsection
