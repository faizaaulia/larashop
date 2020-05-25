@extends('layouts.global')

@section('title', 'Categories List')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('categories.index') }}">
                <div class="input-group">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Filter by category name">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills float-left">
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link active">Published</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.trash') }}" class="nav-link">Trash</a>
                </li>
            </ul>
            <a href="{{ route('categories.create') }}" class="btn btn-primary float-right">Create Category</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <?php 
                $success = session('status-success');
                $error = session('status');

                if (session('status-success'))
                    $status = $success;
                if (session('status'))
                    $status = $error;
            ?>
            @if (isset($status))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-{{ $status == $success ? 'success' : 'warning' }}">
                            {{ $status }}
                        </div>
                    </div>
                </div>
            @endif
            <table class="table shadow-0">
                <thead>
                    <tr>
                        <th><b>Name</b></th>
                        <th><b>Slug</b></th>
                        <th><b>Image</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->slug }}" width="48px">    
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('categories.show', [$category->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                <a href="{{ route('categories.edit', [$category->id]) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', [$category->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Move category to trash?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETe">
                                    <input type="submit" value="Trash" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $categories->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection