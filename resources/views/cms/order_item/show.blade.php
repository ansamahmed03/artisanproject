@extends('cms.parent')
@section('title', 'Show Order Item')
@section('main-title', 'Show Order Item')
@section('sub-title', 'Show Order Item')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Order Item Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Order</label>
                        <input type="text" class="form-control" disabled
                            value="Order #{{ $item->order_id }} — {{ $item->order->customer->email }}">
                    </div>

                    <div class="form-group">
                        <label>Product</label>
                        <input type="text" class="form-control" disabled value="{{ $item->product->name }}">
                    </div>

                    <div class="form-group">
                        <label>Price at Order Time</label>
                        <input type="text" class="form-control" disabled value="${{ $item->price }}">
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" disabled value="{{ $item->quantity }}">
                    </div>

                    <div class="form-group">
                        <label>Subtotal</label>
                        <input type="text" class="form-control" disabled value="${{ $item->price * $item->quantity }}">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('order-items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
