<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
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
        $title = $request->title;
        $sort = $request->sort;

        $categories = Category::query();
        if ($sort && $sort == 'title') {
            $categories = $categories->orderBy($sort);
        }
        if ($title) {
            $categories = $categories->whereTitle($title);
        }
        $categories = $categories->paginate();
        return new CategoryCollection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'data.title' => 'required',
        ]);

        $category = new Category($request->data);
        $category->save();

        if ($category) {
            return response()->json([
                'meta' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'data.title' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->title = $request->data['title'];
        $category->description = null;
        if (isset($request->data['description'])) {
            $category->description = $request->data['description'];
        }

        $category->save();

        if ($category) {
            return response()->json([
                'meta' => 'success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id)->delete();
        if ($category) {
            return response()->json([
                'meta' => 'success'
            ]);
        }
    }
}
