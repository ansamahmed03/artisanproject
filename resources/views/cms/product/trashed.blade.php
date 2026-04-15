 @extends('cms.parent')

@section('main-title', 'Trashed Products')
@section('sub-title', 'Trashed Products')
@section('title', 'Trashed Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Index
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-info text-white">
                        <i class="fas fa-plus-circle"></i> Create New Product
                    </a>
                    <a href="{{ route('products_forceAll') }}" class="btn btn-danger">
                        <i class="fas fa-fire-alt"></i> Empty Trash
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10px">ID</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Artisan</th>
                            <th class="text-center" style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td class="text-center">{{ $product->name }}</td>
                            <td class="text-center">{{ $product->price }}</td>
                            <td class="text-center">{{ $product->status }}</td>
                            <td class="text-center">{{ $product->category->name }}</td>
                            <td class="text-center">{{ $product->artisan->artisan_name }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('products_restore', $product->id) }}" class="btn btn-sm" style="color: #2D6A4F;" title="restore">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                    <a href="{{ route('products_force', $product->id) }}" class="btn btn-sm" style="color: #c0392b;" title="force Delete">
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
        confirmDestroy('/cms/Admin/products_force/' + id, reference);
    }

        </script>

@endsection
