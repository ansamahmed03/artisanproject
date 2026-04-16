@extends('cms.parent')
@section('title', 'Create Review')
@section('main-title', 'Create Review')
@section('sub-title', 'Create Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Review</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" id="customers_id">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Review On</label>
                            <select class="form-control" id="reviewable_type" onchange="toggleReviewable()">
                                <option value="product">Product</option>
                                <option value="artisan">Artisan</option>
                            </select>
                        </div>

                        <div class="form-group" id="product_div">
                            <label>Product</label>
                            <select class="form-control" id="product_reviewable_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="artisan_div" style="display:none;">
                            <label>Artisan</label>
                            <select class="form-control" id="artisan_reviewable_id">
                                @foreach($artisans as $artisan)
                                    <option value="{{ $artisan->id }}">{{ $artisan->artisan_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Rating</label>
                            <select class="form-control" id="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" id="comment" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Add Review</button>
                        <a href="{{ route('reviews.index') }}" class="btn btn-info">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleReviewable() {
        const type = document.getElementById('reviewable_type').value;
        document.getElementById('product_div').style.display = type === 'product' ? 'block' : 'none';
        document.getElementById('artisan_div').style.display = type === 'artisan' ? 'block' : 'none';
    }

    function performStore() {
        const type = document.getElementById('reviewable_type').value;
        const reviewableId = type === 'product'
            ? document.getElementById('product_reviewable_id').value
            : document.getElementById('artisan_reviewable_id').value;

        let formData = new FormData();
        formData.append('customers_id',    document.getElementById('customers_id').value);
        formData.append('reviewable_type', type);
        formData.append('reviewable_id',   reviewableId);
        formData.append('rating',          document.getElementById('rating').value);
        formData.append('comment',         document.getElementById('comment').value);

        store('/cms/Admin/reviews', formData);
    }
</script>
@endsection
