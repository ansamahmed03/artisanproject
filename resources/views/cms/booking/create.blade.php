@extends('cms.parent')
@section('title', 'Create Booking')
@section('main-title', 'Create Booking')
@section('sub-title', 'Create Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Booking</h3>
                </div>
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" id="customer_id">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Team Member</label>
                            <select class="form-control" id="team_id">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Booking Date</label>
                            <input type="date" class="form-control" id="booking_date">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="Optional notes..."></textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Create Booking</button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-info">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let formData = new FormData();
        formData.append('customer_id',  document.getElementById('customer_id').value);
        formData.append('team_id',      document.getElementById('team_id').value);
        formData.append('booking_date', document.getElementById('booking_date').value);
        formData.append('status',       document.getElementById('status').value);
        formData.append('notes',        document.getElementById('notes').value);

        store('/cms/Admin/bookings', formData);
    }
</script>
@endsection
