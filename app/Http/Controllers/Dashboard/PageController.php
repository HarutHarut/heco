<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\PageRequest;
use App\Models\ArticleData;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageData;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $pages = Page::when($search, function ($query) use ($search) {
            $query->whereHas('data', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        })->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.pages.index', compact('pages'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.pages.create');
    }


    /**
     * @param PageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PageRequest $request)
    {
        $page = Page::create([
            'slug' => $request->slug
        ]);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            PageData::create([
                'page_id' => $page->id,
                'title' => $request->title[$localeCode],
                'lang' => $localeCode,
                'description' => $request->description[$localeCode],
                'short_description' => $request->short_description[$localeCode],
            ]);
        }


        flash()->success(__('dashboard_success.page_created'));

        return redirect()->route('pages.index');
    }


    /**
     * @param PageRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PageRequest $request, $id)
    {

        $page = Page::find($id)->update([
            'slug' => $request->slug
        ]);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            PageData::where('page_id', $id)->where('lang', $localeCode)->update([
                'page_id' => $id,
                'title' => $request->title[$localeCode],
                'lang' => $localeCode,
                'description' => $request->description[$localeCode],
                'short_description' => $request->short_description[$localeCode]
            ]);
        }

        flash()->success(__('dashboard_success.page_updated'));

        return redirect()->route('pages.index', ['page' => $request->pagination_page]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        $page = Page::find($id);
        $transData = $page->allData->keyBy('lang');
        return view('dashboard.pages.edit', compact('page', 'transData'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Page::destroy($id);
        flash()->success(__('dashboard_success.page_deleted'));
        return redirect()->route('pages.index');
    }

}
