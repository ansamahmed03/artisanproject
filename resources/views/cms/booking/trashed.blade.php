@extends('cms.parent')
@section('title', 'Trashed Bookings')
@section('main-title', 'Trashed Bookings')
@section('sub-title', 'Trashed Bookings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="gap:5px;">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Index
                        </a>
                        <a href="{{ route('bookings.create') }}" class="btn btn-info text-white">
                            <i class="fas fa-plus-circle"></i> Create New Booking
                        </a>
                        <a href="{{ route('bookings_forceAll') }}" class="btn btn-danger">
                            <i class="fas fa-fire-alt"></i> Empty Trash
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Team Member</th>
                                <th class="text-center">Booking Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Deleted At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="text-center">{{ $booking->id }}</td>
                                <td class="text-center">{{ $booking->customer->email }}</td>
                                <td class="text-center">{{ $booking->team->team_name }}</td>
                                <td class="text-center">{{ $booking->booking_date }}</td>
                                <td class="text-center">{{ ucfirst($booking->status) }}</td>
                                <td class="text-center">{{ $booking->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('bookings_restore', $booking->id) }}"
                                           class="btn btn-sm" style="color:#2D6A4F;">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                        <a href="{{ route('bookings_force', $booking->id) }}"
                                           class="btn btn-sm" style="color:#c0392b;">
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
</div>
@endsection