@extends('cms.parent')
@section('title', 'Addresses')
@section('main-title', 'Index Addresses')
@section('sub-title', 'Index Addresses')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('addresses.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Address
                    </a>
                        <a href="{{ route('addresses_trashed') }}" class="btn btn-success">
        <i class="fas fa-trash-restore"></i> Trashed
    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Street</th>
                                <th class="text-center">Postal Code</th>
                                <th class="text-center">Default</th>
                                <th class="text-center">City</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $address)
                            <tr>
                                <td class="text-center">{{ $address->id }}</td>
                                <td class="text-center">{{ $address->street }}</td>
                                <td class="text-center">{{ $address->postal_code ?? '-' }}</td>
                                <td class="text-center">
                                    @if($address->is_default)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
<td class="text-center">{{ $address->city->name ?? 'Deleted City' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('addresses.show', $address->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $address->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
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
                    {{ $addresses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/addresses/' + id, reference);
    }
</script>
@endsection
