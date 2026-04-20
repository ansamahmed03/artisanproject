@extends('cms.parent')
@section('title', 'Trashed Wishlist')
@section('main-title', 'Trashed Wishlist')
@section('sub-title', 'Trashed Wishlist')

@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex" style="gap:5px;">
                    <a href="{{ route('wishlists.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="{{ route('wishlists_forceAll') }}" class="btn btn-danger"><i class="fas fa-fire-alt"></i> Empty Trash</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Deleted At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $wishlist)
                        <tr>
                            <td class="text-center">{{ $wishlist->id }}</td>
                            <td class="text-center">{{ $wishlist->customer->email }}</td>
                            <td class="text-center">{{ $wishlist->product->name }}</td>
                            <td class="text-center">{{ $wishlist->deleted_at->format('Y-m-d H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('wishlists_restore', $wishlist->id) }}" class="btn btn-sm" style="color:#2D6A4F;"><i class="fas fa-sync"></i></a>
                                <a href="{{ route('wishlists_force', $wishlist->id) }}" class="btn btn-sm" style="color:#c0392b;"><i class="fas fa-skull-crossbones"></i></a>
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
