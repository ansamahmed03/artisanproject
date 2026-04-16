@extends('cms.parent')

@section('title' , 'create team')


@section('main-title' , 'create team')


@section('sub-title' , 'create team')




@section('styles')

@endsection

@section('content')

  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create new team</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>

                <div class="card-body">

                      <div class="form-group">
                    <label for="team_name">team name</label>
                    <input type="text" class="form-control"
                    id="team_name"
                    name="team_name"
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

                   <div class="form-group col-md-6">
                    <label for="hourly_rate">Hourly Rate ($)</label>
                    <input type="number" step="0.01" class="form-control" id="hourly_rate" placeholder="0.00">
                </div>


                 <div class="form-group col-md-6">
                 <label for="city_id">City (Optional)</label>
                 <select class="form-control" id="city_id">
                 <option value="">Select City (Optional)</option>
                  @foreach($cities as $city)
                 <option value="{{ $city->id }}">{{ $city->name }}</option>
                  @endforeach
          </select>
        </div>

                   <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select class="form-control" id="status">
                        <option value="active">Active</option>
                        <option value="busy">Busy</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>


                  <div class="form-group col-md-6">
                    <label for="verification_status">Verification Status</label>
                    <select class="form-control" id="verification_status">
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>




                <div class="form-group col-md-12">
                    <label for="bio">Bio</label>
                    <textarea class="form-control" id="bio" rows="3" placeholder="Enter team bio..."></textarea>
                </div>
            </div>
        </div>


                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="performStore()" class="btn btn-primary">Submit</button>
                <a href="{{ route('teams.index') }}"type="submit" class="btn btn-info">Go back</a>

                </div>
              </form>
            </div>

@endsection



@section('scripts')
    <script>
     function performStore(){
     let formData = new FormData();
     formData.append('team_name', document.getElementById('team_name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('bio', document.getElementById('bio').value);
        formData.append('hourly_rate', document.getElementById('hourly_rate').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('verification_status', document.getElementById('verification_status').value);
        formData.append('city_id', document.getElementById('city_id').value);

     store('/cms/Admin/teams', formData)
     }


    </script>
@endsection

