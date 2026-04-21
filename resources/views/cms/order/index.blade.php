@extends('cms.parent')
@section('title', 'Orders')
@section('main-title', 'Index Orders')
@section('sub-title', 'Index Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('orders.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Order
                    </a>
                    <a href="{{ route('orders_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Status</th>
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
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $order->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/orders/' + id, reference);
    }
</script>
@endsection
