<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\BrandRequest;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $brands = Brand::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->orderBy('id','DESC')->paginate(10);

        return view('dashboard.brands.index', compact('brands'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }


    /**
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BrandRequest $request)
    {
        Brand::create($request->all());
        flash()->success(__('dashboard_success.brand_created'));
        return redirect()->route('brands.index');
    }


    /**
     * @param BrandRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandRequest $request, $id)
    {
        Brand::find($id)->update($request->all());
        flash()->success(__('dashboard_success.brand_updated'));
        return redirect()->route('brands.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('dashboard.brands.edit', compact('brand'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Brand::destroy($id);
        flash()->success(__('dashboard_success.brand_deleted'));
        return redirect()->route('brands.index');
    }

}
