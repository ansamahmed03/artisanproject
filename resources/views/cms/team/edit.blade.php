@extends('cms.parent')

@section('title' , 'Edit Team')
@section('main-title' , 'Edit Team')
@section('sub-title' , 'Edit Team')

@section('styles')
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Team: {{ $teams->team_name }}</h3>
    </div>

    <form id="edit-form">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="team_name">Team Name</label>
                    <input type="text" class="form-control" id="team_name"
                           value="{{ $teams->team_name }}" placeholder="Enter team name">
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email"
                           value="{{ $teams->email }}" placeholder="Enter email">
                </div>

                <div class="form-group col-md-6">
                    <label for="password">Password (Leave blank to keep current)</label>
                    <input type="password" class="form-control" id="password" placeholder="New Password">
                </div>

                <div class="form-group col-md-6">
                    <label for="hourly_rate">Hourly Rate ($)</label>
                    <input type="number" step="0.01" class="form-control" id="hourly_rate"
                           value="{{ $teams->hourly_rate }}" placeholder="0.00">
                </div>

                <div class="form-group col-md-6">
                    <label for="city_id">City</label>
                    <select class="form-control" id="city_id">
                        <option value="">Select City (Optional)</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $teams->city_id == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select class="form-control" id="status">
                        <option value="active" {{ $teams->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="busy" {{ $teams->status == 'busy' ? 'selected' : '' }}>Busy</option>
                        <option value="closed" {{ $teams->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="verification_status">Verification Status</label>
                    <select class="form-control" id="verification_status">
                        <option value="pending" {{ $teams->verification_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ $teams->verification_status == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ $teams->verification_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label for="bio">Bio</label>
                    <textarea class="form-control" id="bio" rows="3">{{ $teams->bio }}</textarea>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" onclick="performUpdate({{ $teams->id }})" class="btn btn-primary">Update</button>
            <a href="{{ route('teams.index') }}" class="btn btn-info">Go back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id) {
        let formData = new FormData();
        // لارافيل يحتاج _method للحذف أو التعديل عند استخدام FormData
        formData.append('_method', 'PUT');

        formData.append('team_name', document.getElementById('team_name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('bio', document.getElementById('bio').value);
        formData.append('hourly_rate', document.getElementById('hourly_rate').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('verification_status', document.getElementById('verification_status').value);
        formData.append('city_id', document.getElementById('city_id').value);

        // إرسال كلمة المرور فقط إذا قام المستخدم بكتابتها
        if(document.getElementById('password').value) {
            formData.append('password', document.getElementById('password').value);
        }

        // الرابط يجب أن يتطابق مع الـ Update في الـ Controller
        storeRoute('/cms/Admin/teams/' + id, formData);
    }
</script>
@endsection
