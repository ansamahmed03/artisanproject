@extends('cms.parent')
@section('title', 'Show Wishlist')
@section('main-title', 'Show Wishlist')
@section('sub-title', 'Show Wishlist')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Wishlist Details</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Customer</label>
                        <input type="text" class="form-control" disabled
                               value="{{ optional($wishlist->customer)->email ?? 'Deleted Customer' }}">                </div>
                <div class="form-group">
                    <label>Product</label>
                    <input type="text" class="form-control" disabled    value="{{ optional($wishlist->product)->name ?? 'Deleted Product' }}">
>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" class="form-control" disabled value="${{ optional($wishlist->product)->price ?? '0' }}">
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('wishlists.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Go To Index
                </a>
            </div>
        </div>
    </div>
</div>
@endsection