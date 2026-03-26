@extends('cms.parent')

@section('title' , 'Edit artisan')


@section('main-title' , 'Edit artisan')


@section('sub-title' , 'Edit artisan')




@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Artisan </h3>
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
                    <label for="artisan_name">artisan name</label>
                    <input type="text" class="form-control"
                    id="artisan_name"
                    name="artisan_name"
                    value="{{ $artisans->artisan_name}}"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email"
                    name="email"
                    value="{{ $artisans->email }}"
                    placeholder="Enter email">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"
                    id="password"
                    name="password"
                    value="{{ $artisans->password }}"
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
                  <button type="submit" class="btn btn-primary">Update</button>
                   <a href="{{ route('cms.admin.artisans.index') }}"type="submit" class="btn btn-info">Go back</a>
                </div>
              </form>
            </div>

@endsection


