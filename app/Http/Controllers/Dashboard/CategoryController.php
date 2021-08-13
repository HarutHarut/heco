<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->orderBy('id','DESC')->paginate(10);

        return view('dashboard.categories.index', compact('categories'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }


    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'status' => $request->status ?? 0
        ]);

        flash()->success(__('dashboard_success.bike_created'));

        return redirect()->route('categories.index');
    }


    /**
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        Category::find($id)->update([
            'name' => $request->name,
            'status' => $request->status ?? 0
        ]);
        flash()->success(__('dashboard_success.category_updated'));
        return redirect()->route('categories.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('dashboard.categories.edit', compact('category'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Category::destroy($id);
        flash()->success(__('dashboard_success.category_deleted'));
        return redirect()->route('categories.index');
    }

}
