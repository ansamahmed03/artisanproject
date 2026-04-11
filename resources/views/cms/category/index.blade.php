@extends('cms.parent')

@section('title' , 'Category')



@section('main-title' , 'Index Category')




@section('sub-title' , 'Index Category')







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
                 <a href="{{ route('categories.create') }}"type="submit" class="btn btn-info">Add new category </a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th class="text-center">Category name</th>
                      <th class="text-center">description</th>
                      <th class="text-center">Action</th>

                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($categories as $category )


                    <tr>
                      <td>{{ $category->id }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->description }}</td>
                    <td class="text-center">
    <a href="{{ route('categories.show' , $category->id ) }}" class="btn btn-sm" style="color: #2ecc71;" title="show">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('categories.edit' , $category->id ) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
        <i class="fas fa-edit"></i>
    </a>

    <form action="#" method="POST" style="display:inline;">
        <button type="button" onclick="performDestroy({{ $category->id  }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
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
              {{ $categories->links() }}
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
            confirmDestroy('/cms/Admin/categories/'+id, reference);




        }



        </script>

@endsection
