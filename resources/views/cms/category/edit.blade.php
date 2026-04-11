@extends('cms.parent')

@section('title' , 'Edit category')


@section('main-title' , 'Edit category')


@section('sub-title' , 'Edit category')




@section('styles')

@endsection



@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Category </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>

                <div class="card-body">
                       {{-- <div class="form-group">
                        <label>Artisan name </label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div> --}}

                      <div class="form-group">
                   <label for="name"> category name</label>
                    <input type="text" class="form-control"
                    id="name"
                    name="name"
                    value="{{ $categories->name}}"
                    placeholder="Enter your name">
                  </div>











<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control"
              id="description"
              name="description"
              rows="3"
              placeholder="Tell us about ">{{ $categories->description }}</textarea>
</div>


                  {{-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div> --}}
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="performUpdate({{ $categories->id }})" class="btn btn-primary">Update</button>
                   <a href="{{ route('categories.index') }}"type="submit" class="btn btn-info">Go back</a>
                </div>
              </form>
            </div>

            @endsection
                @section('scripts')
                   <script>
                 function performUpdate(id){
                    let formData = new FormData() ;
                         formData.append('name',document.getElementById('name').value);


                         formData.append('description', document.getElementById('description').value);

                        //  formData.append('_method', 'PUT');
                     storeRoute('/cms/Admin/categories-update/' + id, formData);

                 }


                </script>
            @endsection

