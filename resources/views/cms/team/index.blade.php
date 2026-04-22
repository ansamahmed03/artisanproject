@extends('cms.parent')

@section('title' , 'Teams')
@section('main-title' , 'Index Team')
@section('sub-title' , 'Index Team')

@section('styles')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(auth('admin')->check())
                    <div class="card-header">

                        <a href="{{ route('teams.create') }}" class="btn btn-info">Add new Team</a>
                        <a href="{{ route('teams_trashed') }}" class="btn btn-warning">
                            <i class="fas fa-trash"></i> Trashed
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">ID</th>
                                    <th>Team Name</th>
                                    {{-- <th>Email</th> --}}
                                    {{-- <th>Hourly Rate</th> --}}
                                    <th>City</th>
                                    <th>Status</th>
                                    <th class="text-center">Verification</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $team)
                                <tr>
                                    <td>{{ $team->id }}</td>
                                    <td>{{ $team->team_name }}</td>
                                    {{-- <td>{{ $team->email }}</td> --}}
                                    {{-- <td>{{ $team->hourly_rate }}$</td> --}}
                                    <td>{{ $team->city->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($team->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($team->status == 'busy')
                                            <span class="badge bg-warning">Busy</span>
                                        @else
                                            <span class="badge bg-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                      @if($team->verification_status == 'verified')
                                    <span class="badge bg-primary"><i class="fas fa-check-circle"></i> Verified</span>
                                     @elseif($team->verification_status == 'pending')
                                      <span class="badge bg-secondary"><i class="fas fa-clock"></i> Pending</span>
                                         @elseif($team->verification_status == 'rejected')
                                              <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                               @else
                                           <span class="badge bg-light text-dark">Unknown</span>
                                          @endif
                                            </td>
                                    <td class="text-center">
                                       <a href="{{ route('teams.show', ['guard' => request()->segment(2), 'team' => $team->id]) }}" class="btn btn-sm" style="color: #2ecc71;" title="show">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth('admin')->check())

                                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm" style="color: #3498db;" title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button type="button" onclick="performDestroy({{ $team->id }}, this)" class="btn btn-sm" style="color: #e74c3c;" title="delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        // تأكد أن الرابط يطابق الـ Route في web.php
        confirmDestroy('/cms/admin/teams/' + id, reference);
    }
</script>
@endsection
