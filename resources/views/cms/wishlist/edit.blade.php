@extends('cms.parent')
@section('title', 'Edit Wishlist')
@section('main-title', 'Edit Wishlist')
@section('sub-title', 'Edit Wishlist')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Edit Wishlist</h3></div>
            <form>
                <div class="card-body">
                    <div class="form-group">
                        <label>Customer</label>
                        <select class="form-control" id="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @if($customer->id == $wishlist->customer_id) selected @endif>
                                    {{ $customer->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product</label>
                        <select class="form-control" id="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" @if($product->id == $wishlist->product_id) selected @endif>
                                    {{ $product->name }} — ${{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="performUpdate({{ $wishlist->id }})" class="btn btn-primary">Update</button>
                    <a href="{{ route('wishlists.index') }}" class="btn btn-secondary">Go To Index</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function performUpdate(id) {
        let formData = new FormData();
        formData.append('customer_id', document.getElementById('customer_id').value);
        formData.append('product_id',  document.getElementById('product_id').value);
        storeRoute('/cms/Admin/wishlists_update/' + id, formData);
    }
</script>
@endsection