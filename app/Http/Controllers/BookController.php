<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('title') ? $request->get('title') : '';

        if ($status)
            $books = \App\Book::with('categories')->where('title', 'LIKE', "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        else
            $books = \App\Book::with('categories')->where('title', 'LIKE', "%$keyword%")->paginate(10);

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new \App\Book;
        $book->title = $request->get('title');
        $book->description = $request->get('description');
        $book->author = $request->get('author');
        $book->publisher = $request->get('publisher');
        $book->price = $request->get('price');
        $book->stock = $request->get('stock');
        $book->description = $request->get('description');
        $book->status = $request->get('save_action');
        $book->slug = \Str::slug($request->get('title'));
        $book->created_by = \Auth::user()->id;

        if ($request->file('cover')) {
            $cover = $request->file('cover')
                             ->store('books_cover', 'public');
            $book->cover = $cover;
        }

        $book->save();
        $book->categories()->attach($request->get('categories'));
        if ($request->get('save_action') == 'PUBLISH')
            return redirect()->route('books.create')->with('status', 'Book successfully saved and published');
        else
            return redirect()->route('books.create')->with('status', 'Book saved as draft');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = \App\Book::findOrFail($id);

        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = \App\Book::findOrFail($id);

        $book->title = $request->get('title');
        $book->description = $request->get('description');
        $book->stock = $request->get('stock');
        $book->author = $request->get('author');
        $book->publisher = $request->get('publisher');
        $book->price = $request->get('price');
        $book->slug = \Str::slug($request->title);
        $book->updated_by = \Auth::user()->id;
        $book->status = $request->get('status');

        if ($request->file('cover')) {
            if ($book->cover && file_exists(storage_path('app/public/' . $book->cover)))
                \Storage::delete('public/' . $book->cover);
            
            $cover = $request->file('cover')->store('book_covers', 'public');
            $book->cover = $cover;
        }

        $book->save();
        $book->categories()->sync($request->get('categories'));

        return redirect()->route('books.edit', [$id])->with('status', 'Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = \App\Book::findOrFail($id);

        $book->delete();
        return redirect()->route('books.index')->with('status', 'Book moved to trash');
    }

    public function trash(Request $request) {
        $title = $request->get('title');

        if ($title)
            $books = \App\Book::onlyTrashed()->where('title', 'LIKE', "%$title%")->paginate(10);
        else
            $books = \App\Book::onlyTrashed()->paginate(10);

        return view('books.trash', ['books' => $books]);
    }

    public function restore($id) {
        $book = \App\Book::withTrashed()->findOrFail($id);

        if ($book->trashed()) {
            $book->restore();
            return redirect()->route('books.trash')->with('status', 'Book successfully restored');
        } else
            return redirect()->route('books.trash')->with('status', 'Book is not in trash');
    }

    public function deletePermanent($id) {
        $book = \App\Book::withTrashed()->findOrFail($id);

        if (!$book->trashed())
            return redirect()->route('books.trash')->with('status', 'Book is not in trash')->with('status_type', 'alert');
        else
            $book->categories()->detach();
            $book->forceDelete();

            return redirect()->route('books.trash')->with('status', 'Book permanently deleted');
    }
}
