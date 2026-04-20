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
                        <label>ID</label>
                        <input type="text" class="form-control" disabled value="{{ $address->id }}">
                    </div>

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
                        <input type="text" class="form-control" disabled value="{{ $address->city->name ?? 'Deleted City' }}">
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" disabled value="{{ $address->city->country->country_name ?? 'Deleted Country' }}">
                    </div>

                    <div class="form-group">
                        <label>Default Address</label>
                        <input type="text" class="form-control" disabled value="{{ $address->is_default ? 'Yes' : 'No' }}">
                    </div>

                    <div class="form-group">
                        <label>Created At</label>
                        <input type="text" class="form-control" disabled value="{{ $address->created_at->format('Y-m-d H:i') }}">
                    </div>

                    <div class="form-group">
                        <label>Updated At</label>
                        <input type="text" class="form-control" disabled value="{{ $address->updated_at->format('Y-m-d H:i') }}">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                    <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection

