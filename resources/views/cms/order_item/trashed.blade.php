@extends('cms.parent')
@section('title', 'Trashed Order Items')
@section('main-title', 'Trashed Order Items')
@section('sub-title', 'Trashed Order Items')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card-header">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <a href="{{ route('order-items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Index
                    </a>
                    <a href="{{ route('order-items.create') }}" class="btn btn-info text-white">
                        <i class="fas fa-plus-circle"></i> Create New Item
                    </a>
                    <a href="{{ route('order-items_forceAll') }}" class="btn btn-danger">
                        <i class="fas fa-fire-alt"></i> Empty Trash
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Order #</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center" style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">#{{ $item->order_id }}</td>
                            <td class="text-center">{{ $item->product->name }}</td>
                            <td class="text-center">${{ $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">${{ $item->price * $item->quantity }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('order-items_restore', $item->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                    <a href="{{ route('order-items_force', $item->id) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
                                        <i class="fas fa-skull-crossbones"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
