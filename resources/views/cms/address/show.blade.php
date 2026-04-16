@extends('cms.parent')
@section('title', 'Show Address')
@section('main-title', 'Show Address')
@section('sub-title', 'Show Address')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Address Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Street</label>
                        <input type="text" class="form-control" disabled value="{{ $address->street }}">
                    </div>

                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" disabled value="{{ $address->postal_code ?? '-' }}">
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" disabled value="{{ $address->city->name }}">
                    </div>

                    <div class="form-group">
                        <label>Default Address</label>
                        <input type="text" class="form-control" disabled value="{{ $address->is_default ? 'Yes' : 'No' }}">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
