@extends('cms.parent')

@section('title' , 'create category')


@section('main-title' , 'create category')


@section('sub-title' , 'create category')




@section('styles')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create new Category</h3>
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
                    <label for="name"> category name</label>
                    <input type="text" class="form-control"
                    id="name"
                    name="name"
                    placeholder="Enter your category">
                  </div>
                  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
</div>

{{--
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

                  <div class="form-group">
    <label for="store_name">Store Name</label>
    <input type="text" class="form-control"
           id="store_name"
           name="store_name"
           placeholder="Enter store name">
</div>

<div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control"
           id="city"
           name="city"
           placeholder="Enter city">
</div>

<div class="form-group">
    <label for="bio">Bio</label>
    <textarea class="form-control"
              id="bio"
              name="bio"
              rows="3"
              placeholder="Tell us about yourself"></textarea>
</div>

<div class="form-group">
    <label for="bank_info">Bank Information</label>
    <input type="text" class="form-control"
           id="bank_info"
           name="bank_info"
           placeholder="Enter bank account or IBAN">
</div>

 --}}






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
                <a href="{{ route('categories.index') }}"type="submit" class="btn btn-info">Go back</a>

                </div>
              </form>
            </div>

@endsection



@section('scripts')
    <script>
     function performStore(){
     let formData = new FormData();
     formData.append('name',document.getElementById('name').value);

     formData.append('description', document.getElementById('description').value);

     store('/cms/Admin/categories', formData)
     }


    </script>
@endsection

