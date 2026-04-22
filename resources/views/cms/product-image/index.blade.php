@extends('cms.parent')
@section('main-title', 'Product Images')
@section('sub-title', 'Product Images')
@section('title', 'Product Images')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('product-images.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Upload New Image
                    </a>
                    <a href="{{ route('product-images_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
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
                                <td class="text-center">{{ $image->product->name }}</td>
                                <td class="text-center">
                                    @if($image->is_primary)
                                        <span class="badge badge-success">Primary</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('product-images.show', $image->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('product-images.edit', $image->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $image->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
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
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/product-images/' + id, reference);
    }
</script>
@endsection
