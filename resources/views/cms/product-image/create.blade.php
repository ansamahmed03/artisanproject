@extends('cms.parent')
@section('main-title', 'Upload Image')
@section('sub-title', 'Upload Image')
@section('title', 'Upload Image')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload Product Image</h3>
                </div>
                <form id="create_form">
                    <div class="card-body">

                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control" id="product_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" id="image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_primary" value="1">
                                <label class="form-check-label" for="is_primary">Set as Primary Image</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Upload</button>
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
    function performStore() {
        let formData = new FormData();
        formData.append('product_id', document.getElementById('product_id').value);
        formData.append('image',      document.getElementById('image').files[0]);
        formData.append('is_primary', document.getElementById('is_primary').checked ? 1 : 0);

        store('/cms/Admin/product-images', formData);
    }
</script>
@endsection
