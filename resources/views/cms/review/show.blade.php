@extends('cms.parent')
@section('title', 'Show Review')
@section('main-title', 'Show Review')
@section('sub-title', 'Show Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Review Details</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text" class="form-control" disabled value="{{ $review->customer->email }}">
                    </div>

                    <div class="form-group">
                        <label>Review On</label>
                        <input type="text" class="form-control" disabled
                            value="{{ class_basename($review->reviewable_type) }}">
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" disabled
                            value="{{ $review->reviewable->name ?? $review->reviewable->artisan_name ?? '-' }}">
                    </div>

                    <div class="form-group">
                        <label>Rating</label>
                        <div class="form-control" style="background:#f9f9f9;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f39c12' : '#ccc' }}"></i>
                            @endfor
                            ({{ $review->rating }}/5)
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" disabled rows="3">{{ $review->comment }}</textarea>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go To Index
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection