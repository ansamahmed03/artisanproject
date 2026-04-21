@extends('cms.parent')
@section('title', 'Trashed Orders')
@section('main-title', 'Trashed Orders')
@section('sub-title', 'Trashed Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="gap:5px;">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Index
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn btn-info text-white">
                            <i class="fas fa-plus-circle"></i> Create New Order
                        </a>
                        <a href="{{ route('orders_forceAll') }}" class="btn btn-danger">
                            <i class="fas fa-fire-alt"></i> Empty Trash
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Deleted At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                               @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{ $order->id }}</td>
                                <td class="text-center">{{ $order->customer->email ?? 'Deleted Customer' }}</td>
                                <td class="text-center">${{ $order->total_price }}</td>
                                <td class="text-center">{{ $order->orderItems->count() }}</td>
                                <td class="text-center">
                                    @php
                                        $colors = [
                                            'pending'    => 'warning',
                                            'processing' => 'info',
                                            'shipped'    => 'primary',
                                            'delivered'  => 'success',
                                            'cancelled'  => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $colors[$order->order_status] }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('orders_restore', $order->id) }}"
                                           class="btn btn-sm" style="color:#2D6A4F;" title="Restore">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                        <a href="{{ route('orders_force', $order->id) }}"
                                           class="btn btn-sm" style="color:#c0392b;" title="Force Delete">
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
</div>
@endsection
