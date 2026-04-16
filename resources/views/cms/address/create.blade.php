@extends('cms.parent')
@section('title', 'Create Address')
@section('main-title', 'Create Address')
@section('sub-title', 'Create Address')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Address</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" class="form-control" id="street" placeholder="Enter street">
                        </div>

                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" placeholder="Enter postal code">
                        </div>

                        <div class="form-group">
                            <label>City</label>
                            <select class="form-control" id="city_id">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_default">
                                <label class="custom-control-label" for="is_default">Set as Default Address</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Add Address</button>
                        <a href="{{ route('addresses.index') }}" class="btn btn-info">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let formData = new FormData();
        formData.append('street',      document.getElementById('street').value);
        formData.append('postal_code', document.getElementById('postal_code').value);
        formData.append('city_id',     document.getElementById('city_id').value);
        formData.append('is_default',  document.getElementById('is_default').checked ? 1 : 0);

        store('/cms/Admin/addresses', formData);
    }
</script>
@endsection
