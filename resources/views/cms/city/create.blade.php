@extends('cms.parent')

@section('create-title' , 'Create City')
@section('create', 'Create City')

@section('styles')
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">City Table</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('cities.create') }}" class="btn btn-primary mb-3">Create New City</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Street</th>
                                <th class="text-center" style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                            <tr>
                                <td class="text-center">{{ $city->id }}</td>
                                <td class="text-center">{{ $city->name }}</td>
                                <td class="text-center">{{ $city->street }}</td>
                                {{-- جلب اسم الدولة عبر العلاقة --}}


                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('cities.show', $city->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" onclick="performDestroy({{ $city->id }}, this)" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
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
    function performStore() {
        let formData = new FormData();
        formData.append('City_name', document.getElementById('City_name').value);
        formData.append('street', document.getElementById('street').value);
        formData.append('country_id', document.getElementById('country_id').value);


        store('/cms/Admin/cities', formData);
    }
</script>
@endsection
