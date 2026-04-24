@extends('cms.parent')

@section('title' , 'create artisan')


@section('main-title' , 'create artisan')


@section('sub-title' , 'create artisan')




@section('styles')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create new Artisan</h3>
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
                    <label for="artisan_name">artisan name</label>
                    <input type="text" class="form-control"
                    id="artisan_name"
                    name="artisan_name"
                    placeholder="Enter your name">
                  </div>


                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter email">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"
                    id="password"
                    name="password"
                    placeholder="Password">
                  </div>

                  <div class="form-group">
    <label for="store_name">Store Name</label>
    <input type="text" class="form-control"
           id="store_name"
           name="store_name"
           placeholder="Enter store name">
</div>

<div class="form-group">
    <label for="city_id">City</label>
    <select name="city_id" id="city_id" class="form-control">
        <option value="">Choose City (Optional)</option>
        @foreach($cities as $city)
            <option value="{{ $city->id }}"
                {{ isset($artisans) && $artisans->city_id == $city->id ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="bio">Bio</label>
    <textarea class="form-control"
              id="bio"
              name="bio"
              rows="3"
              placeholder="Tell us about yourself"></textarea>
</div>

<div class="form-group">
    <label for="bank_info">Bank Information</label>
    <input type="text" class="form-control"
           id="bank_info"
           name="bank_info"
           placeholder="Enter bank account or IBAN">
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
                  <button type="button" onclick="performStore()" class="btn btn-primary">Submit</button>
                <a href="{{ route('artisans.index', ['guard' => 'Admin']) }}" type="submit" class="btn btn-info">Go back</a>

                </div>
              </form>
            </div>

@endsection



@section('scripts')
    <script>
     function performStore(){
     let formData = new FormData();
     formData.append('artisan_name',document.getElementById('artisan_name').value);
     formData.append('email',document.getElementById('email').value);
     formData.append('password',document.getElementById('password').value);
     formData.append('store_name', document.getElementById('store_name').value);
       formData.append('city', 'سيتي');
     formData.append('bio', document.getElementById('bio').value);
    formData.append('city_id', document.getElementById('city_id').value);
     formData.append('bank_info', document.getElementById('bank_info').value);
     store('/cms/Admin/artisans', formData)
     }


    </script>
@endsection

