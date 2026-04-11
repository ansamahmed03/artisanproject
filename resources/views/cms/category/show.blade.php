@extends('cms.parent')

@section('title' , 'Show Category Details')
@section('main-title' , 'Show Category')
@section('sub-title' , 'Category Details')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Show data of Category</h3>
    </div>

    <form>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control"
                       id="name" disabled
                       value="{{ $categories->name }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description"
                          rows="4" disabled>{{ $categories->description }}</textarea>
            </div>



        </div>
        <div class="card-footer">
            {{-- زر العودة لجدول الأصناف --}}
            <a href="{{ route('categories.index') }}" class="btn btn-info">Go back</a>
        </div>
    </form>
</div>

@endsection
