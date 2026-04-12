@extends('cms.parent')

@section('Show Data Of Country-title' , 'main-title')
@section('Show Data Of Country', 'sub-title')
@section('Show Data of Country', 'title')



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
                <h3 class="card-title">Show Data Of Country</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div  class="card-body">
                  <div   class="form-group">
                    <label for="country_name">Country Name</label>
                    <input  type="text"
                    class="form-control" disabled
                     id="country_name"
                     name="country_name"
                     value="{{ $countries->country_name}}"
                     placeholder="Enter Country Name">


                  </div>
                  <div  class="form-group">
                    <label for="code">Code</label>
                    <input type="text"
                     class="form-control" disabled
                     id="code"
                     name="code"
                     value="{{ $countries->code }}"
                   placeholder="Enter Code">
                  </div>




                  </div> <!-- -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
    <!--             <button type="submit" class="btn btn-primary">Add</button> -->
                   <a  href="{{ route('countries.index') }}" type="submit" class="btn btn-primary">GO Back</a>
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

@endsection
