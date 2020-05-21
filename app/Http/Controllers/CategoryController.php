<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = \App\Category::paginate(10);

        $keyword = $request->get('keyword');
        if ($keyword)
            $categories = \App\Category::where('name', 'LIKE', "%$keyword%")->paginate(10);

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $category = new \App\Category;
        $category->name = $name;

        if ($request->file('image')) {
            $image = $request->file('image')
                             ->store('category_images', 'public');
            $category->image = $image;
        }

        $category->created_by = \Auth::user()->id;
        $category->slug = \Str::slug($name, '-');

        $category->save();

        return redirect()->route('categories.create')->with('status', 'Category successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = \App\Category::findOrFail($id);

        return view('categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = \App\Category::findOrFail($id);

        return view('categories.edit', ['category' => $category]);
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
        $name = $request->get('name');
        $slug = \Str::slug($name, '-');
        
        $category = \App\Category::findOrFail($id);
     
        $category->name = $name;
        $category->slug = $slug;
        $category->updated_by = \Auth::user()->id;

        if ($request->file('image')) {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image)))
                \Storage::delete('public/' . $category->image);

            $image = $request->file('image')->store('category_images', 'public');
            $category->image = $image;
        }

        $category->save();
        return redirect()->route('categories.edit', [$id])->with('status', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category successfully moved to trash');
    }

    public function trash() {
        $categories = \App\Category::onlyTrashed()->paginate(10);

        return view('categories.trash', ['categories' => $categories]);
    }

    public function restore($id) {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if ($category->trashed())
            $category->restore();
        else
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
            
        return redirect()->route('categories.index')->with('status-success', 'Category successfully resotred');
    }

    public function deletePermanent($id) {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if (!$category->trashed())
            return redirect()->route('categories.index')->with('status', 'Can not permanently delete active category');
        else {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image)))
                \Storage::delete('public/' . $category->image);
                
            $category->forceDelete();
            return redirect()->route('categories.index')->with('status-success', 'Category permanently deleted');
        }
    }
}
