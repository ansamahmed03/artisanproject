@extends('cms.parent')
@section('main-title', 'Show Image')
@section('sub-title', 'Show Image')
@section('title', 'Show Image')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Image Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group text-center">
                        <img src="{{ asset('storage/' . $image->image_path) }}" style="max-width:400px; border-radius:10px;">
                    </div>

                    <div class="form-group">
                        <label>Product</label>
                        <input type="text" class="form-control" disabled value="{{ $image->product->name }}">
                    </div>

                    <div class="form-group">
                        <label>Primary</label>
                        <input type="text" class="form-control" disabled value="{{ $image->is_primary ? 'Yes' : 'No' }}">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('product-images.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                    <a href="{{ route('product-images.edit', $image->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
