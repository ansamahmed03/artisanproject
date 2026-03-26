@extends('cms.parent')

@section('title' , 'Show data of artisan')


@section('main-title' , 'Show data of artisan')


@section('sub-title' , 'Show data of artisan')




@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Show data of Artisan </h3>
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
                    id="artisan_name" disabled
                    name="artisan_name"
                    value="{{ $artisans->artisan_name}}"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email" disabled
                    name="email"
                    value="{{ $artisans->email }}"
                    placeholder="Enter email">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"
                    id="password" disabled
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


