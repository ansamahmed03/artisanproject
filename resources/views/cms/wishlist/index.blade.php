@extends('cms.parent')
@section('title', 'Wishlist')
@section('main-title', 'Index Wishlist')
@section('sub-title', 'Index Wishlist')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('wishlists.create') }}" class="btn btn-info" style="color:white;">
                    <i class="fas fa-plus-circle"></i> Add to Wishlist
                </a>
                <a href="{{ route('wishlists_trashed') }}" class="btn btn-success">
                    <i class="fas fa-trash-restore"></i> Trashed
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $wishlist)
                        <tr>
                            <td class="text-center">{{ $wishlist->id }}</td>
                            <td class="text-center">{{ optional($wishlist->customer)->email ?? 'Deleted Customer' }}</td>
                          <td class="text-center">{{ optional($wishlist->product)->name ?? 'Deleted Product' }}</td>
                            <td class="text-center">${{ optional($wishlist->product)->price ?? '0' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-sm" style="color:#2ecc71;"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('wishlists.edit', $wishlist->id) }}" class="btn btn-sm" style="color:#3498db;"><i class="fas fa-edit"></i></a>
                                    <button onclick="performDestroy({{ $wishlist->id }}, this)" class="btn btn-sm" style="color:#e74c3c;"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">{{ $wishlists->links() }}</div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/wishlists/' + id, reference);
    }
</script>
@endsection
