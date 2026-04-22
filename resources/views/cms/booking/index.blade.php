@extends('cms.parent')
@section('title', 'Bookings')
@section('main-title', 'Index Bookings')
@section('sub-title', 'Index Bookings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('bookings.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Booking
                    </a>
                    <a href="{{ route('bookings_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
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
                                <th class="text-center">Notes</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $colors = [
                                    'pending'   => 'warning',
                                    'confirmed' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="text-center">{{ $booking->id }}</td>
                                <td class="text-center">{{ $booking->customer->email }}</td>
                                <td class="text-center">{{ $booking->team->team_name }}</td>
                                <td class="text-center">{{ $booking->booking_date }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $colors[$booking->status] }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $booking->notes ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $booking->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
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
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/bookings/' + id, reference);
    }
</script>
@endsection
