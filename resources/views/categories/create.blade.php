@extends('layouts.global')

@section('title', 'Create Category')

@section('content')
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <label for="name">Category Name</label> <br>
            <input type="text" name="name" id="name" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div><br>

            <label for="image">Category Image</label> <br>
            <input type="file" name="image" id="image" class="form-control {{ $errors->first('image') ? 'is-invalid' : '' }}">
            <div class="invalid-feedback">
                {{ $errors->first('image') }}
            </div><br>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
@endsection