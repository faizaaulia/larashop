@extends('layouts.global')

@section('title', 'Edit Category')

@section('content')
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('categories.update', [$category->id]) }}" method="post" class="bg-white shadow-sm p-3" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <label for="name">Category Name</label> <br>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}"> <br>

            <label for="name">Category Slug</label> <br>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ $category->slug }}" disabled> <br>

            @if ($category->image)
                <span>Current image:</span><br>
                <img src="{{ asset('storage/' . $category->image) }}" alt="category image" width="120px"> <br><br>
            @endif

            <label for="image">Category Image</label> <br>
            <input type="file" name="image" id="image" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small> <br><br>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
@endsection