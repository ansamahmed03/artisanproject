@extends('cms.parent')

@section('title' , 'create Product')


@section('main-title' , 'create Product')


@section('sub-title' , 'create product')




@section('styles')

@endsection

@section('content')

 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Product</h3>
                    </div>
                              <form>
<div class="card-body">

  <div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control"
           id="name"
           name="name"
           placeholder="Enter product name">
  </div>

  <div class="form-group">
    <label for="price">Price</label>
    <input type="number" class="form-control"
           id="price"
           name="price"
           placeholder="Enter price">
  </div>

  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control"
              id="description"
              name="description"
              rows="3"></textarea>
  </div>

  <div class="form-group">
    <label for="stock_quantity">Stock Quantity</label>
    <input type="number" class="form-control"
           id="stock_quantity"
           name="stock_quantity">
  </div>

  <div class="form-group">
    <label for="artisans_id">Artisan</label>
    <input type="number" class="form-control"
           id="artisan_id"
           name="artisan_id">
  </div>

  <div class="form-group">
    <label for="categories_id">Category</label>
    <input type="number" class="form-control"
           id="category_id"
           name="category_id">
  </div>

  <div class="form-group">
    <label for="status">Status</label>
    <select class="form-control" id="status" name="status">
    <option value="available">Available</option>
    <option value="out_of_stock">Out of Stock</option>
    <option value="pending">Pending</option>
</select>
  </div>

</div>

<div class="card-footer">
  <button type="button" onclick="performStore()" class="btn btn-primary">Add product</button>
  <a href="{{ route('products.index') }}" class="btn btn-info">Go To index</a>
</div>
</form>






@endsection



@section('scripts')
    <script>
     function performStore(){
     let formData = new FormData();
      formData.append('name', document.getElementById('name').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('stock_quantity', document.getElementById('stock_quantity').value);
    formData.append('artisan_id', document.getElementById('artisan_id').value);
    formData.append('category_id', document.getElementById('category_id').value);
    formData.append('status', document.getElementById('status').value);

     store('/cms/Admin/products', formData);
     }


    </script>
@endsection

