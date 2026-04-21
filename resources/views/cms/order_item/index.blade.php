@extends('cms.parent')
@section('title', 'Order Items')
@section('main-title', 'Index Order Items')
@section('sub-title', 'Index Order Items')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('order-items.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Item
                    </a>
<a href="{{ route('order-items_trashed') }}" class="btn btn-success">
    <i class="fas fa-trash-restore"></i> Trashed
</a>
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
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td class="text-center">#{{ optional($item->order)->id ?? 'Deleted Order' }}</td>
                                <td class="text-center">{{ $item->product->name ?? 'Deleted Product' }}
                                    @if(!$item->product || $item->product->trashed())
            <span class="badge badge-danger">Deleted</span>
        @endif
    </td>
                                <td class="text-center">${{ $item->price }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">${{ $item->price * $item->quantity }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('order-items.show', $item->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('order-items.edit', $item->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $item->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
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
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/order-items/' + id, reference);
    }
</script>
@endsection
