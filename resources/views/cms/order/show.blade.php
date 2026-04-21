@extends('cms.parent')
@section('title', 'Show Order')
@section('main-title', 'Show Order')
@section('sub-title', 'Show Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Order #{{ $order->id }} Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text" class="form-control" disabled value="{{ $order->customer->email }}">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                    <input type="text" class="form-control" disabled value="{{ $order->address->street ?? 'Deleted Address' }}">                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" disabled value="{{ ucfirst($order->order_status) }}">
                    </div>

                    <div class="form-group">
                        <label>Total Price</label>
                        <input type="text" class="form-control" disabled value="${{ $order->total_price }}">
                    </div>

                    <hr>
                    <h5>Order Items</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td class="text-center">{{ $item->product->name ?? 'Deleted Product' }}
                                <td>${{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ $item->price * $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
