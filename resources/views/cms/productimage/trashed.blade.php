@extends('cms.parent')
@section('main-title', 'Trashed Images')
@section('sub-title', 'Trashed Images')
@section('title', 'Trashed Images')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <a href="{{ route('product-images.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Index
                    </a>
                    <a href="{{ route('product-images.create') }}" class="btn btn-info text-white">
                        <i class="fas fa-plus-circle"></i> Upload New Image
                    </a>
                    <a href="{{ route('product-images_forceAll') }}" class="btn btn-danger">
                        <i class="fas fa-fire-alt"></i> Empty Trash
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Primary</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($images as $image)
                        <tr>
                            <td class="text-center">{{ $image->id }}</td>
                            <td class="text-center">
                                <img src="{{ asset('storage/' . $image->image_path) }}" width="80" height="60" style="object-fit:cover; border-radius:5px;">
                            </td>
<td class="text-center">{{ optional($image->product)->name ?? 'Deleted Product' }}</td>                            <td class="text-center">
                                @if($image->is_primary)
                                    <span class="badge badge-success">Primary</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('product-images_restore', $image->id) }}" class="btn btn-sm" style="color:#2D6A4F;" title="restore">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                    <a href="{{ route('product-images_force', $image->id) }}" class="btn btn-sm" style="color:#c0392b;" title="force Delete">
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
