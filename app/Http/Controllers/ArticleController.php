<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->title;
        $date = $request->date;
        $sort = $request->sort;

        $articles = Article::query();
        if ($sort && ($sort == 'title' || $sort == 'date')) {
            $articles = $articles->orderBy($sort);
        }
        if ($title) {
            $articles = $articles->whereTitle($title);
        }
        if ($date) {
            $articles = $articles->whereDate($date);
        }
        $articles = $articles->paginate();
        return new ArticleCollection($articles);
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
            'data.text' => 'required',
            'data.date' => 'required|date_format:Y-m-d',
            'data.category_id' => 'required|exists:categories,id',
        ]);

        $article = new Article($request->data);
        $article->save();

        if ($article) {
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
        $article = Article::findOrFail($id);
        return new ArticleResource($article);
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
            'data.text' => 'required',
            'data.date' => 'required|date_format:Y-m-d',
            'data.category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->data['title'];
        $article->text = $request->data['text'];
        $article->date = $request->data['date'];
        $article->category_id = $request->data['category_id'];
        $article->short_description = null;
        if (isset($request->data['short_description'])) {
            $article->short_description = $request->data['short_description'];
        }

        $article->save();

        if ($article) {
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
        $article = Article::findOrFail($id)->delete();
        if ($article) {
            return response()->json([
                'meta' => 'success'
            ]);
        }
    }
}
