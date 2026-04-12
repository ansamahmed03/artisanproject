@extends('cms.parent')

@section('create-title' , 'main-title')
@section('create', 'sub-title')
@section('create', 'title')



@section('styles')

@endsection

@section('content')

<div class="container-fluid">
    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul"></ul>
    </div>

    </div>

 <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Country</h3>
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
                     placeholder="Enter Country Name">


                  </div>
                  <div  class="form-group">
                    <label for="code">Code</label>
                    <input type="text"
                     class="form-control"
                     id="code"
                     name="code"
                      placeholder="Enter Code">
                  </div>


                  </div> <!-- -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                   <button type="button" onclick="performStore()" class="btn btn-primary">Add</button>
                     <a  href="{{ route('countries.index') }}" type="submit" class="btn btn-primary">GO TO index</a>
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
                    function performStore(){
                        let formData = new FormData();

                            formData.append('country_name',document.getElementById('country_name').value);
                              formData.append('code',document.getElementById('code').value);
                              store ('/cms/Admin/countries', formData)
                        }


                </script>

@endsection
