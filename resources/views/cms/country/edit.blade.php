@extends('cms.parent')

@section('main-title' , 'Edit-title')
@section('sub-title', 'edit')
@section('title', 'edit')



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
                    <label for="country_name">Country Name</label>
                    <input  type="text"
                    class="form-control"
                     id="country_name"
                     name="country_name"
                     value="{{ $countries->country_name }}"
                     placeholder="Enter Country Name">


                  </div>
                  <div  class="form-group">
                    <label for="code">Code</label>
                    <input type="text"
                     class="form-control"
                     id="code"
                     name="code"
                     value="{{ $countries->code }}"
                   placeholder="Enter Code">
                  </div>


                  </div> <!-- -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="performUpdate({{ $countries->id }})" class="btn btn-primary">Update</button>
                   <a  href="{{ route('countries.index') }}"  class="btn btn-primary">GO Back</a>
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
             formData.append('country_name',document.getElementById('country_name').value);
             formData.append('code',document.getElementById('code').value);

             location.reload();
                     storeRoute('/cms/Admin/countries_update/'+id ,formData)



        }






      </script>

@endsection
