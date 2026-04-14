@extends('cms.parent')

@section('Edit-title' , 'Edit City')
@section('Edit', 'Edit City')

@section('styles')
@endsection

@section('content')
<div id="error_alert" class="alert alert-danger" hidden>
    <ul id="error_messages_ul" style="margin-bottom: 0;"></ul>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div id="error_alert" class="alert alert-danger" hidden>
                    <ul id="error_messages_ul"></ul>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit City</h3>
                    </div>
                    <form id="create-form">
                        <div class="card-body">

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Country name</label>
                                        <select class="form-control select2" name="country_id" id="country_id" style="width: 100%;">




                                              @foreach ($countries as $country)
        <option value="{{ $country->id }}" @if($country->id == $cities->country_id) selected @endif>
            {{ $country->country_name }}
        </option>
    @endforeach


                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">City Name</label>
                                <input type="text" class="form-control" id="name" name="name"  value="{{ $cities->name }}" placeholder="Enter City Name">
                            </div>

                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" id="street" name="street"  value="{{ $cities->street }}" placeholder="Enter Street">
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="performUpdate({{ $cities->id }})" class="btn btn-primary">Add</button>
                            <a href="{{ route('cities.index') }}" class="btn btn-secondary">GO TO Index</a>
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

           function performUpdate (id){
           let formData = new FormData();
             formData.append('name',document.getElementById('name').value);
             formData.append('street',document.getElementById('street').value);
             formData.append('country_id',document.getElementById('country_id').value);
             formData.append('_method', 'PUT');
                     storeRoute('/cms/Admin/cities_update/'+id ,formData)
    }
</script>
@endsection
