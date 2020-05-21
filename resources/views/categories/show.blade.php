@extends('layouts.global')

@section('title', 'Category Detail')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label for="name"><b>Category Name</b></label> <br>
                {{ $category->name }} <br><br>
                
                <label for="slug"><b>Category slug</b></label> <br>
                {{ $category->slug }} <br><br>
                
                <label for="image"><b>Category image</b></label> <br>
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="category image" width="120px">
                @endif
            </div>
        </div>
    </div>
@endsection