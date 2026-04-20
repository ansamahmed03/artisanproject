@extends('cms.parent')
@section('title', 'Add to Wishlist')
@section('main-title', 'Add to Wishlist')
@section('sub-title', 'Add to Wishlist')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Add to Wishlist</h3></div>
            <form>
                <div class="card-body">
                    <div class="form-group">
                        <label>Customer</label>
                        <select class="form-control" id="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product</label>
                        <select class="form-control" id="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} — ${{ $product->price }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="performStore()" class="btn btn-primary">Add</button>
                    <a href="{{ route('wishlists.index') }}" class="btn btn-info">Go To Index</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function performStore() {
        let formData = new FormData();
        formData.append('customer_id', document.getElementById('customer_id').value);
        formData.append('product_id',  document.getElementById('product_id').value);
        store('/cms/Admin/wishlists', formData);
    }
</script>
@endsection