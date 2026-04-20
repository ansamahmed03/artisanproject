@@extends('cms.parent')
@section('title', 'Reviews')
@section('main-title', 'Index Reviews')
@section('sub-title', 'Index Reviews')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('reviews.create') }}" class="btn btn-info" style="color:white;">
                        <i class="fas fa-plus-circle"></i> Create New Review
                    </a>
                    <a href="{{ route('reviews_trashed') }}" class="btn btn-success">
                        <i class="fas fa-trash-restore"></i> Trashed
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">On</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Comment</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td class="text-center">{{ $review->id }}</td>
                                <td class="text-center">{{ $review->customer->email }}</td>
                                <td class="text-center">
                                    @if($review->reviewable_type === 'App\Models\Product')
                                        <span class="badge badge-primary">Product</span>
                                    @else
                                        <span class="badge badge-warning">Artisan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $review->reviewable->name ?? $review->reviewable->artisan_name ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f39c12' : '#ccc' }}"></i>
                                    @endfor
                                </td>
                                <td class="text-center">{{ Str::limit($review->comment, 50) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm" style="color:#2ecc71;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm" style="color:#3498db;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="performDestroy({{ $review->id }}, this)" class="btn btn-sm" style="color:#e74c3c;">
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
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/Admin/reviews/' + id, reference);
    }
</script>
@endsection