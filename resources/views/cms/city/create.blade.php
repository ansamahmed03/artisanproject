@extends('cms.parent')

@section('create-title', 'Create City')
@section('create', 'Create City')

@section('styles')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New City</h3>
                    </div>

                    <div id="error_alert" hidden class="alert alert-danger m-3">
                        <ul id="error_messages_ul"></ul>
                    </div>

                    <form id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Country Name</label>
                                <select class="form-control" id="country_id" name="country_id" style="width: 100%;">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="City_name">City Name</label>
                                <input type="text" class="form-control" id="City_name" placeholder="Enter Name of City">
                            </div>

                            <div class="form-group">
                                <label for="street">City street</label>
                                <input type="text" class="form-control" id="street" placeholder="Enter street">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
                            <a href="{{ route('cities.index') }}" class="btn btn-success">Go To Index</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
<script>
    function performStore() {
        let formData = new FormData();
        formData.append('name', document.getElementById('City_name').value);
        formData.append('street', document.getElementById('street').value);
        formData.append('country_id', document.getElementById('country_id').value);


        store('/cms/Admin/cities', formData);
    }
</script>
@endsection
