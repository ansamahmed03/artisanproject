@extends('cms.parent')
@section('title', 'Trashed Reviews')
@section('main-title', 'Trashed Reviews')
@section('sub-title', 'Trashed Reviews')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="gap:5px;">
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Index
                        </a>
                        <a href="{{ route('reviews_forceAll') }}" class="btn btn-danger">
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
                                <th class="text-center">On</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Deleted At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td class="text-center">{{ $review->id }}</td>
                                <td class="text-center">{{ $review->customer->email }}</td>
                                <td class="text-center">{{ class_basename($review->reviewable_type) }}</td>
                                <td class="text-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f39c12' : '#ccc' }}"></i>
                                    @endfor
                                </td>
                                <td class="text-center">{{ $review->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('reviews_restore', $review->id) }}"
                                           class="btn btn-sm" style="color:#2D6A4F;">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                        <a href="{{ route('reviews_force', $review->id) }}"
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