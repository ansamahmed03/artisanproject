@extends('cms.parent')

@section('title' , 'Show Team Details')
@section('main-title' , 'Show Team Details')
@section('sub-title' , 'Show Team Details')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Details of Team: {{ $team->team_name }}</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Team Name</label>
                <input type="text" class="form-control" value="{{ $team->team_name }}" disabled>
            </div>

            <div class="form-group col-md-6">
                <label>Email Address</label>
                <input type="email" class="form-control" value="{{ $team->email }}" disabled>
            </div>

            <div class="form-group col-md-4">
                <label>Hourly Rate</label>
                <div class="input-group">
                    <input type="text" class="form-control" value="{{ $team->hourly_rate }}" disabled>
                    <div class="input-group-append">
                        <span class="input-group-text">$</span>
                    </div>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label>City</label>
                <input type="text" class="form-control" value="{{ $team->city->name ?? 'Not Assigned' }}" disabled>
            </div>

            <div class="form-group col-md-4">
                <label>Status</label>
                <div>
                    @if($team->status == 'active')
                        <span class="badge badge-success p-2">Active</span>
                    @elseif($team->status == 'busy')
                        <span class="badge badge-warning p-2">Busy</span>
                    @else
                        <span class="badge badge-danger p-2">Closed</span>
                    @endif
                </div>
            </div>

            <div class="form-group col-md-6">
                <label>Verification Status</label>
                <div>
                    @if($team->verification_status == 'verified')
                        <span class="badge badge-primary p-2"><i class="fas fa-check-circle"></i> Verified</span>
                    @elseif($team->verification_status == 'pending')
                        <span class="badge badge-secondary p-2"><i class="fas fa-clock"></i> Pending</span>
                    @else
                        <span class="badge badge-danger p-2"><i class="fas fa-times-circle"></i> Rejected</span>
                    @endif
                </div>
            </div>

            <div class="form-group col-md-12">
                <label>Bio / Description</label>
                <textarea class="form-control" rows="4" disabled>{{ $team->bio }}</textarea>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">Edit Team Data</a>
        <a href="{{ route('teams.index', ['guard' => request()->segment(2)]) }}" class="btn btn-info">Go back</a>
    </div>
</div>
@endsection
