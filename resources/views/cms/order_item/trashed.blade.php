@extends('cms.parent')

@section('main-title', 'Trashed Order Items')
@section('sub-title', 'Trashed Order Items')
@section('title', 'trashed')

@section('styles')
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card-header">
                <div class="d-flex align-items-center" style="gap: 5px;">
<a href="{{ route('order-items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to index Order Items
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
                            <th class="text-center" style="width: 10px">ID</th>
                            <th class="text-center">Order #</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Deleted At</th>
                            <th class="text-center" style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($orderItems as $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ $item->order->order_number ?? '-' }}</td>
                            <td class="text-center">{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td class="text-center">{{ $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ $item->price * $item->quantity }}</td>
                            <td class="text-center">{{ $item->deleted_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('order-items_restore', $item->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="Restore">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                    <a href="{{ route('order-items_force', $item->id) }}" class="btn btn-sm" style="color: #c0392b;" title="Force Delete">
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

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/order-items/force/' + id, reference);
    }
</script>
@endsection
