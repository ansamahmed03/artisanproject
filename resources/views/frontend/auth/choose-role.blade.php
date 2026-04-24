@extends('frontend.layout.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="mb-4">Choose Account Type</h2>

    <div class="row justify-content-center">

        <div class="col-md-3">
            <a href="{{ route('register.customer') }}" class="btn btn-primary w-100 mb-3">
                Customer
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('register.artisan') }}" class="btn btn-success w-100 mb-3">
                Artisan
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('register.team') }}" class="btn btn-dark w-100 mb-3">
                Team
            </a>
        </div>

    </div>
</div>
@endsection