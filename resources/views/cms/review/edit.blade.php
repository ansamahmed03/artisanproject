@@extends('cms.parent')
@section('title', 'Edit Review')
@section('main-title', 'Edit Review')
@section('sub-title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Review</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" id="customers_id">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        @if($customer->id == $review->customers_id) selected @endif>
                                        {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $currentType = class_basename($review->reviewable_type) === 'Product' ? 'product' : 'artisan';
                        @endphp

                        <div class="form-group">
                            <label>Review On</label>
                            <select class="form-control" id="reviewable_type" onchange="toggleReviewable()">
                                <option value="product" @if($currentType == 'product') selected @endif>Product</option>
                                <option value="artisan" @if($currentType == 'artisan') selected @endif>Artisan</option>
                            </select>
                        </div>

                        <div class="form-group" id="product_div"
                            style="{{ $currentType == 'product' ? '' : 'display:none;' }}">
                            <label>Product</label>
                            <select class="form-control" id="product_reviewable_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        @if($currentType == 'product' && $product->id == $review->reviewable_id) selected @endif>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="artisan_div"
                            style="{{ $currentType == 'artisan' ? '' : 'display:none;' }}">
                            <label>Artisan</label>
                            <select class="form-control" id="artisan_reviewable_id">
                                @foreach($artisans as $artisan)
                                    <option value="{{ $artisan->id }}"
                                        @if($currentType == 'artisan' && $artisan->id == $review->reviewable_id) selected @endif>
                                        {{ $artisan->artisan_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Rating</label>
                            <select class="form-control" id="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" @if($review->rating == $i) selected @endif>
                                        {{ $i }} ⭐
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" id="comment" rows="3">{{ $review->comment }}</textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $review->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Go To Index</a>
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

    function performUpdate(id) {
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

        storeRoute('/cms/Admin/reviews_update/' + id, formData);
    }
</script>
@endsection