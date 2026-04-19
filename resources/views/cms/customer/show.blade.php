@extends('cms.parent')

@section('title' , 'Show data of customer')


@section('main-title' , 'Show data of customer')


@section('sub-title' , 'Show data of customer')




@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Show data of customers </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>

                <div class="card-body">

                      <div class="form-group">
                    <label for="name">customer name</label>
                    <input type="text" class="form-control"
                    id="name" disabled
                    name="full_name"
                    value="{{ $customers->name}}"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email" disabled
                    name="email"
                    value="{{ $customers->email }}"
                    placeholder="Enter email">
                  </div>

                <!-- /.card-body -->

                <div class="card-footer">

                   <a href="{{ route('customers.index', ['guard' => request()->segment(2)]) }}"type="submit" class="btn btn-info">Go back</a>
                </div>
              </form>
            </div>

@endsection


