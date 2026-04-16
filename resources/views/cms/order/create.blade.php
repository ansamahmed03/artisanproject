@extends('cms.parent')
@section('title', 'Create Order')
@section('main-title', 'Create Order')
@section('sub-title', 'Create Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Order</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" id="customer_id">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <select class="form-control" id="address_id">
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->street }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="order_status">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        {{-- Order Items --}}
                        <hr>
                        <h5>Order Items</h5>
                        <div id="items-container">
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
                        </div>

                        <button type="button" onclick="addRow()" class="btn btn-secondary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Add Product
                        </button>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Create Order</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-info">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- template row مخفي للـ JS --}}
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

    function performStore() {
        let formData = new FormData();
        formData.append('customer_id',  document.getElementById('customer_id').value);
        formData.append('address_id',   document.getElementById('address_id').value);
        formData.append('order_status', document.getElementById('order_status').value);

        document.querySelectorAll('.item-row').forEach((row, index) => {
            formData.append(`items[${index}][product_id]`, row.querySelector('.product-select').value);
            formData.append(`items[${index}][quantity]`,   row.querySelector('.quantity-input').value);
        });

        store('/cms/Admin/orders', formData);
    }
</script>
@endsection
