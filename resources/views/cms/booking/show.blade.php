@extends('cms.parent')
@section('title', 'Show Booking')
@section('main-title', 'Show Booking')
@section('sub-title', 'Show Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Booking #{{ $booking->id }} Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text" class="form-control" disabled value="{{ $booking->customer->email }}">
                    </div>

                    <div class="form-group">
                        <label>Team Member</label>
                        <input type="text" class="form-control" disabled value="{{ $booking->team->team_name }}">
                    </div>

                    <div class="form-group">
                        <label>Booking Date</label>
                        <input type="text" class="form-control" disabled value="{{ $booking->booking_date }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" disabled value="{{ ucfirst($booking->status) }}">
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" disabled rows="3">{{ $booking->notes ?? '-' }}</textarea>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
