@extends('cms.parent')


@section('main-title', 'Edit Product')
@section('sub-title', 'Edit Product')
@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>

                <form id="create_form">
                    <div class="card-body">

                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $products->name }}">
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" id="price" value="{{ $products->price }}">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" id="description" rows="3">{{ $products->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" value="{{ $products->stock_quantity }}">
                        </div>

                        <div class="form-group">
                            <label>Artisan</label>
                            <select class="form-control" id="artisan_id">
                                @foreach($artisans as $artisan)
                                    <option value="{{ $artisan->id }}" @if($artisan->id == $products->artisan_id) selected @endif>
                                        {{ $artisan->artisan_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $products->category_id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option value="available"    @if($products->status == 'available')    selected @endif>Available</option>
                                <option value="out_of_stock" @if($products->status == 'out_of_stock') selected @endif>Out of Stock</option>
                                <option value="pending"      @if($products->status == 'pending')      selected @endif>Pending</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $products->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id) {
        let formData = new FormData();
        formData.append('name',           document.getElementById('name').value);
        formData.append('price',          document.getElementById('price').value);
        formData.append('description',    document.getElementById('description').value);
        formData.append('stock_quantity', document.getElementById('stock_quantity').value);
        formData.append('artisan_id',     document.getElementById('artisan_id').value);
        formData.append('category_id',    document.getElementById('category_id').value);
        formData.append('status',         document.getElementById('status').value);

        storeRoute('/cms/Admin/products_update/' + id, formData);
    }
</script>
@endsection
