@extends('cms.parent')
@section('title', 'Create Order Item')
@section('main-title', 'Create Order Item')
@section('sub-title', 'Create Order Item')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Order Item</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Order</label>
                            <select class="form-control" id="order_id">
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">
                                        Order #{{ $order->id }} — {{ $order->customer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control" id="product_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} — ${{ $product->price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="quantity" min="1" value="1">
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Add Item</button>
                        <a href="{{ route('order-items.index') }}" class="btn btn-info">Go To Index</a>
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
        formData.append('order_id',   document.getElementById('order_id').value);
        formData.append('product_id', document.getElementById('product_id').value);
        formData.append('quantity',   document.getElementById('quantity').value);

        store('/cms/Admin/order-items', formData);
    }
</script>
@endsection
