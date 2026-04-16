@extends('cms.parent')

@section('title' , 'Show data of Product')


@section('main-title' , 'Show data of Product')


@section('sub-title' , 'Show data of Product')




@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Show Product Details</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" disabled value="{{ $products->name }}">
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" disabled value="{{ $products->price }}">
                    </div>

                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="text" class="form-control" disabled value="{{ $products->stock_quantity }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" disabled rows="3">{{ $products->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" disabled value="{{ $products->status }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" disabled value="{{ $products->category->name }}">
                    </div>

                    <div class="form-group">
                        <label>Artisan</label>
                        <input type="text" class="form-control" disabled value="{{ $products->artisan->artisan_name }}">
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
@endsection
