@extends('cms.parent')
@section('title', 'Edit Order Item')
@section('main-title', 'Edit Order Item')
@section('sub-title', 'Edit Order Item')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Order Item</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Order</label>
                            <select class="form-control" id="order_id">
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}"
                                        @if($order->id == $item->order_id) selected @endif>
                                        Order #{{ $order->id }} — {{ $order->customer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control" id="product_id">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        @if($product->id == $item->product_id) selected @endif>
                                        {{ $product->name }} — ${{ $product->price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="quantity"
                                min="1" value="{{ $item->quantity }}">
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $item->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('order-items.index') }}" class="btn btn-secondary">Go To Index</a>
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
        formData.append('order_id',   document.getElementById('order_id').value);
        formData.append('product_id', document.getElementById('product_id').value);
        formData.append('quantity',   document.getElementById('quantity').value);

        storeRoute('/cms/Admin/order-items_update/' + id, formData);
    }
</script>
@endsection
