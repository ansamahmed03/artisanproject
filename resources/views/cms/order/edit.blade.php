@extends('cms.parent')
@section('title', 'Edit Order')
@section('main-title', 'Edit Order')
@section('sub-title', 'Edit Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Order #{{ $order->id }}</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" id="customer_id">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        @if($customer->id == $order->customer_id) selected @endif>
                                        {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <select class="form-control" id="address_id">
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}"
                                        @if($address->id == $order->address_id) selected @endif>
                                        {{ $address->street }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="order_status">
                                @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                    <option value="{{ $status }}"
                                        @if($order->order_status == $status) selected @endif>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h5>Order Items</h5>
                        <div id="items-container">
                            @foreach($order->orderItems as $item)
                            <div class="row item-row mb-2">
                                <div class="col-md-6">
                                    <select class="form-control product-select">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                @if($product->id == $item->product_id) selected @endif>
                                                {{ $product->name }} - ${{ $product->price }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control quantity-input"
                                        placeholder="Quantity" min="1" value="{{ $item->quantity }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addRow()" class="btn btn-secondary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Add Product
                        </button>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $order->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<template id="item-template">
    <div class="row item-row mb-2">
        <div class="col-md-6">
            <select class="form-control product-select">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control quantity-input" placeholder="Quantity" min="1" value="1">
        </div>
        <div class="col-md-2">
            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
    function addRow() {
        const template = document.getElementById('item-template').content.cloneNode(true);
        document.getElementById('items-container').appendChild(template);
    }

    function removeRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) btn.closest('.item-row').remove();
    }

    function performUpdate(id) {
        let formData = new FormData();
        formData.append('customer_id',  document.getElementById('customer_id').value);
        formData.append('address_id',   document.getElementById('address_id').value);
        formData.append('order_status', document.getElementById('order_status').value);

        document.querySelectorAll('.item-row').forEach((row, index) => {
            formData.append(`items[${index}][product_id]`, row.querySelector('.product-select').value);
            formData.append(`items[${index}][quantity]`,   row.querySelector('.quantity-input').value);
        });

        storeRoute('/cms/Admin/orders_update/' + id, formData);
    }
</script>
@endsection
