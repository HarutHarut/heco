<?php

namespace App\Http\Controllers;


use App\Models\Article;

class BlogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $articles = Article::where('status', 1)->orderBy('id', 'desc')->get();
        $most_popular = Article::orderBy('count_of_visits', 'DESC')->where('status', 1)->limit(4)->get();
        (new \App\Services\SeoService())->seoForPage('blog');
        return view('blog.index', compact('articles', 'most_popular'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $article->count_of_visits = $article->count_of_visits + 1;
        $article->save();

        $articles = Article::where('id', '!=', $article->id)->where('status', 1)->inRandomOrder()->take(3)->get();

        return view('blog.show', compact('article', 'articles'));
    }
}
