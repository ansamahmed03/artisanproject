@extends('cms.parent')

@section('main-title' , 'Index City')
@section('sub-title', ' Index City')
@section('title', 'index City')



@section('styles')

@endsection

@section('content')

<div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">

              <div class="card-header">
                 <a href="{{ route('cities.create') }}" class="btn btn-info" style="color: white;">
                 <i class="fas fa-plus-circle"></i> Create New City
                   </a>
               <a href="{{ route('cities_trashed') }}" class="btn btn-success">
                     <i class="fas fa-trash-restore"></i> Trashed
                 </a>
              </div>
 <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Street</th>
<td class="text-center">{{ $city->country->country_name ?? 'Deleted Country' }}</td>
                                <th class="text-center" style="width: 150px">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                            <tr>
                                <td class="text-center">{{ $city->id }}</td>
                                <td class="text-center">{{ $city->name }}</td>
                                <td class="text-center">{{ $city->street }}</td>
                                <td class="text-center">{{ $city->country->country_name }}</td>
                                {{-- جلب اسم الدولة عبر العلاقة --}}


                                <td class="text-center">
                                    <div class="btn-group">


                                          <a href="{{ route('cities.show', $city->id)}}" class="btn btn-sm" style="color: #2ecc71;" title="show">
                                             <i class="fas fa-eye"></i>
                                          </a>

                                        <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                              <i class="fas fa-edit"></i>
                                           </a>

                                      <button type="button" onclick="performDestroy({{$city->id  }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete" >
                                          <i class="fas fa-trash-alt"></i>
                                          </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $cities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')


        <script>
            function performDestroy(id , reference){

                 confirmDestroy ('/cms/Admin/cities/' +id , reference);
            }



        </script>

@endsection
