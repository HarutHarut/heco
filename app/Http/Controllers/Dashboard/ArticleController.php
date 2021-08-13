<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\ArticleRequest;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Article;
use App\Models\ArticleData;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Detail;
use App\Services\DataService;
use App\Services\ImagesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArticleController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $articles = Article::when($search, function ($query) use ($search) {
            $query->whereHas('data', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        })->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.articles.index', compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.articles.create');
    }


    /**
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::create([
            'slug' => DataService::getSlug($request->title['en']),
            'status' => $request->status ?? 0,
        ]);

        if ($request['image']) {
            Article::find($article->id)->update([
                'image' => ImagesService::savePhoto($request['image'], 'articles/' . $article->id)
            ]);
        }
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ArticleData::create([
                'article_id' => $article->id,
                'title' => $request->title[$localeCode],
                'lang' => $localeCode,
                'description' => $request->description[$localeCode],
                'short_description' => $request->short_description[$localeCode],
            ]);
        }

        flash()->success(__('dashboard_success.article_created'));

        return redirect()->route('articles.index');
    }


    /**
     * @param ArticleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = Article::find($id)->update([
            'slug' => DataService::getSlug($request->title['en']),
            'status' => $request->status ?? 0,
        ]);
        if ($request['image']) {
            Article::find($id)->update([
                'image' => ImagesService::savePhoto($request['image'], 'articles/' . $id)
            ]);
        }
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ArticleData::where('article_id', $id)->where('lang', $localeCode)->update([
                'article_id' => $id,
                'title' => $request->title[$localeCode],
                'lang' => $localeCode,
                'description' => $request->description[$localeCode],
                'short_description' => $request->short_description[$localeCode]
            ]);
        }

        flash()->success(__('dashboard_success.article_updated'));
        return redirect()->route('articles.index', [
            'page' => $request->page,
            'search' => $request->search
        ]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $article = Article::find($id);
        $transData = $article->allData->keyBy('lang');
        return view('dashboard.articles.edit', compact('article', 'transData'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        Article::destroy($id);
        flash()->success(__('dashboard_success.article_deleted'));
        return redirect()->route('articles.index', [
            'page' => $request->page,
            'search' => $request->search
        ]);
    }

}
