@extends('cms.parent')
@section('title', 'Trashed Addresses')
@section('main-title', 'Trashed Addresses')
@section('sub-title', 'Trashed Addresses')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="gap:5px;">
                        <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Index
                        </a>
                        <a href="{{ route('addresses.create') }}" class="btn btn-info text-white">
                            <i class="fas fa-plus-circle"></i> Create New Address
                        </a>
                        <a href="{{ route('addresses_forceAll') }}" class="btn btn-danger">
                            <i class="fas fa-fire-alt"></i> Empty Trash
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Street</th>
                                <th class="text-center">Postal Code</th>
                                <th class="text-center">City</th>
                                <th class="text-center">Deleted At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $address)
                            <tr>
                                <td class="text-center">{{ $address->id }}</td>
                                <td class="text-center">{{ $address->street }}</td>
                                <td class="text-center">{{ $address->postal_code ?? '-' }}</td>
                                <td class="text-center">{{ $address->city->name }}</td>
                                <td class="text-center">{{ $address->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('addresses_restore', $address->id) }}"
                                           class="btn btn-sm" style="color:#2D6A4F;" title="Restore">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                        <a href="{{ route('addresses_force', $address->id) }}"
                                           class="btn btn-sm" style="color:#c0392b;" title="Force Delete">
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
