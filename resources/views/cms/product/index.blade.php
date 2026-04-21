@extends('cms.parent')

@section('title' , 'Product')



@section('main-title' , 'Index Product')




@section('sub-title' , 'Index Product')







@section('styles')


@endsection


@section('content')

 <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('products.create') }}" class="btn btn-info" style="color: white;">
                        <i class="fas fa-plus-circle"></i> Create New Product
                    </a>
                    <a href="{{ route('products_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">ID</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Stock</th>
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
<td class="text-center">
    @if($product->images->count() > 0)
        @php $firstImage = $product->images->first(); @endphp

        {{-- هنا قمنا بحذف img-circle واستبداله بكلاسات تجعلها مربعة --}}
        <img src="{{ asset('storage/' . $firstImage->image_path) }}"
             width="100" height="70" {{-- جرب تغيير الأرقام لتناسبك --}}
             class="img-bordered-sm img-size-64" {{-- كلاسات AdminLTE بديلة --}}
             style="border-radius: 5px; object-fit: cover;" {{-- ستايل يدوي لجوانب ناعمة --}}
             alt="Product Image">
    @else
        <img src="{{ asset('assets/img/default-product.png') }}"
             width="70" height="70"
             style="border-radius: 5px;"
             alt="No Image">
    @endif
</td>
                                <td class="text-center">{{ $product->price }}</td>
                                <td class="text-center">{{ $product->stock_quantity }}</td>
                                <td class="text-center">
                                    @if($product->status == 'available')
                                        <span class="badge badge-success">Available</span>
                                    @elseif($product->status == 'out_of_stock')
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                    <td class="text-center">{{ $product->category?->name }}</td>
                                <td class="text-center">{{ $product->artisan->artisan_name }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm" style="color: #2ecc71;" title="show">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" onclick="performDestroy({{ $product->id }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete">
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


@section('scripts')

         <script>
        function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/products/' + id, reference);
    }



        </script>

@endsection
