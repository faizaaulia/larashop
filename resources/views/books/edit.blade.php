@extends('layouts.global')

@section('title', 'Edit Book')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('books.update', [$book->id]) }}" class="shadow-sm bg-white p-3" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <label for="title">Title</label> <br>
                <input type="text" name="title" id="title" class="form-control" placeholder="Book Title" value="{{ $book->title }}"> <br>

                <label for="cover">Cover</label> <br>
                <small class="text-muted">Current cover</small> <br>
                @if ($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->slug }}" width="96px">
                @endif <br><br>
                <input type="file" name="cover" id="cover" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small> <br><br>

                <label for="description">Description</label> <br>
                <textarea name="description" id="description" class="form-control" placeholder="Description about this book">{{ $book->description }}</textarea> <br>

                <label for="categories">Categories</label> <br>
                <select name="categories[]" id="categories" class="form-control" multiple="multiple"></select> <br><br>

                <label for="stock">Stock</label> <br>
                <input type="number" name="stock" id="stock" min="0" class="form-control" value="{{ $book->stock }}"> <br>

                <label for="author">Author</label> <br>
                <input type="text" name="author" id="author" placeholder="Book Author" class="form-control" value="{{ $book->author }}"> <br>

                <label for="publisher">Publisher</label> <br>
                <input type="text" name="publisher" id="publisher" placeholder="Book Publisher" class="form-control" value="{{ $book->publisher }}"> <br>

                <label for="price">Price</label> <br>
                <input type="number" name="price" id="price" placeholder="Book Price" class="form-control" value="{{ $book->price }}"> <br>

                <label for="status">Status</label> <br>
                <select name="status" id="status" class="form-control">
                    <option value="PUBLISH" {{ $book->status == 'PUBLISH'? 'selected' : '' }}> PUBLISH</option>
                    <option value="DRAFT" {{ $book->status == 'DRAFT'? 'selected' : '' }}> DRAFT</option>
                </select> <br>

                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#categories').select2({
                ajax: {
                    url: "{{ route('categories.ajax.search') }}",
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id, text: item.name
                                }
                            });
                        }
                    }
                }
            });

            var categories = {!! $book->categories !!}
            categories.forEach(function(category) {
                var option = new Option(category.name, category.id, true, true); //params: text, value, defaultSelected, selected
                $('#categories').append(option).trigger('change');
            });
        })
    </script>
@endsection