@extends('layouts.global')

@section('title', 'Books List')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <form action="{{ route('books.index') }}">
                <div class="input-group">
                    <input type="text" name="title" id="title" class="form-control" value="{{ Request::get('title') }}" placeholder="Filter by title">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <div class="col">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="{{ route('books.index') }}" class="nav-link {{ Request::get('status') == NULL && Request::path() == 'books' ? 'active' : '' }}">All</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.index', ['status' => 'publish', 'title' => Request::get('title')]) }}" class="nav-link {{ Request::get('status') == 'publish' ? 'active' : '' }}">Publish</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.index', ['status' => 'draft', 'title' => Request::get('title')]) }}" class="nav-link {{ Request::get('status') == 'draft' ? 'active' : '' }}">Draft</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.trash') }}" class="nav-link {{ Request::path() == 'books/trash' ? 'active' : '' }}">Trash</a>
                </li>
            </ul>
        </div>
        <div class="col text-right">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Create Book</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table shadow-0">
                <thead>
                    <tr>
                        <th><b>Cover</b></th>
                        <th><b>Title</b></th>
                        <th><b>Author</b></th>
                        <th><b>Publisher</b></th>
                        <th><b>Categories</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Price</b></th>
                        <th><b>Status</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                @if ($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->slug }}" width="96px">
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td>
                                <ul pl-3>
                                    @foreach ($book->categories as $category)
                                        <li>{{ $category->name }}</li>
                                    @endforeach    
                                </ul>    
                            </td>
                            <td>{{ $book->stock }}</td>
                            <td>{{ $book->price }}</td>
                            <td>
                                <span class="badge {{ $book->status == 'PUBLISH' ? 'badge-success' : 'bg-dark text-white' }}"> {{ $book->status }} </span>
                            </td>
                            <td>
                                <a href="{{ route('books.edit', [$book->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('books.destroy', [$book->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Move book to trash?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Trash" class="btn btn-sm btn-danger">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $books->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection