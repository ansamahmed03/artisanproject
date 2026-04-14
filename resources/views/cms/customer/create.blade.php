@extends('cms.parent')

@section('title' , 'create customer')


@section('main-title' , 'create customer')


@section('sub-title' , 'create customer')




@section('styles')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create new customer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>

                <div class="card-body">
                       {{-- <div class="form-group">
                        <label>Artisan name </label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div> --}}

                      <div class="form-group">
                    <label for="name">customer name</label>
                    <input type="text" class="form-control"
                    id="name"
                    name="name"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter email">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"
                    id="password"
                    name="password"
                    placeholder="Password">
                  </div>









                  {{-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div> --}}
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="performStore()" class="btn btn-primary">Submit</button>
                <a href="{{ route('customers.index') }}"type="submit" class="btn btn-info">Go back</a>

                </div>
              </form>
            </div>

@endsection



@section('scripts')
    <script>
     function performStore(){
     let formData = new FormData();
     formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
    //  formData.append('First_name', document.getElementById('First_name').value);
    //     formData.append('Last_name', document.getElementById('Last_name').value);

     store('/cms/Admin/customers', formData)
     }


    </script>
@endsection

