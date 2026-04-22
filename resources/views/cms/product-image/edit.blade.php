@extends('cms.parent')
@section('main-title', 'Edit Image')
@section('sub-title', 'Edit Image')
@section('title', 'Edit Image')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product Image</h3>
                </div>
                <form id="create_form">
                    <div class="card-body">

                        <div class="form-group text-center">
                            <label>Current Image</label><br>
                            <img src="{{ asset('storage/' . $image->image_path) }}" width="200" style="border-radius:10px;">
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control" id="product_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" @if($product->id == $image->product_id) selected @endif>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>New Image (optional)</label>
                            <input type="file" class="form-control" id="image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_primary" value="1" {{ $image->is_primary ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_primary">Set as Primary Image</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $image->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('product-images.index') }}" class="btn btn-secondary">Go To Index</a>
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
        formData.append('product_id', document.getElementById('product_id').value);
        formData.append('is_primary', document.getElementById('is_primary').checked ? 1 : 0);

        let imageFile = document.getElementById('image').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        storeRoute('/cms/Admin/product-images_update/' + id, formData);
    }
</script>
@endsection
