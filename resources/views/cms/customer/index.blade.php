@extends('cms.parent')

@section('title' , 'customer')



@section('main-title' , 'Index customer')




@section('sub-title' , 'Index customer')







@section('styles')


@endsection


@section('content')


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                {{-- <h3 class="card-title">Artisan Table</h3> --}}
                 <a href="{{ route('customers.create') }}"type="submit" class="btn btn-info">Add new Customer </a>
                     <a href="{{route('customers_trashed')}}" class="btn btn-warning">
                  <i class="fas fa-trash"></i> trashed
                   </a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th class="text-center">customer name</th>
                      <th class="text-center">email</th>

                      <th class="text-center">Action</th>

                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($customers as $customer )


                    <tr>
                      <td>{{ $customer->id }}</td>
                      <td>{{ $customer->name }}</td>

                      <td>{{ $customer->email }}</td>
                      <td class="text-center">
    <a href="{{ route('customers.show', ['guard' => request()->segment(2), 'id' => $customer->id]) }}" class="btn btn-sm" style="color: #2ecc71;" title="show">
        <i class="fas fa-eye"></i>
    </a>
@if(auth('admin')->check())
    <a href="{{ route('customers.edit' ,$customer->id ) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
        <i class="fas fa-edit"></i>
    </a>

    <form action="#" method="POST" style="display:inline;">
        <button type="button" onclick="performDestroy({{ $customer->id  }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
    @endif
</td>




                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              {{-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div> --}}
              {{ $customers->links() }}
            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
        <!-- /.row -->




        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection



@section('scripts')

         <script>
        function performDestroy(id,reference){
            confirmDestroy('/cms/Admin/customers/'+id, reference);




        }



        </script>

@endsection
