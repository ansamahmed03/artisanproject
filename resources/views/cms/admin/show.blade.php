@extends('cms.parent')

@section('title' , 'Show data of admin')


@section('main-title' , 'Show data of admin')


@section('sub-title' , 'Show data of admin')




@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Show data of Admins </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>

                <div class="card-body">

                      <div class="form-group">
                    <label for="full_name">admin name</label>
                    <input type="text" class="form-control"
                    id="full_name" disabled
                    name="full_name"
                    value="{{ $admins->full_name}}"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email" disabled
                    name="email"
                    value="{{ $admins->email }}"
                    placeholder="Enter email">
                  </div>

                <!-- /.card-body -->

                <div class="card-footer">

                   <a href="{{ route('admins.index') }}"type="submit" class="btn btn-info">Go back</a>
                </div>
              </form>
            </div>

@endsection


