<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\BrandModelRequest;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ModelController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $brand_id = $request->get('brand', null);

        $models = BrandModel::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })->when($brand_id, function ($q) use ($brand_id) {
            return $q->where('brand_id', $brand_id);
        })->orderBy('id','DESC')->paginate(10);

        $brands = Brand::all();
        return view('dashboard.models.index', compact('models', 'brands'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');

        return view('dashboard.models.create', compact('brands'));
    }


    /**
     * @param BrandModelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BrandModelRequest $request)
    {
        BrandModel::create($request->all());

        flash()->success(__('dashboard_success.model_created'));

        return redirect()->route('models.index');
    }


    /**
     * @param BrandModelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandModelRequest $request, $id)
    {

        BrandModel::find($id)->update($request->all());
        flash()->success(__('dashboard_success.model_updated'));

        return redirect()->route('models.index',['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = BrandModel::find($id);
        $brands = Brand::pluck('name', 'id');

        return view('dashboard.models.edit', compact('model', 'brands'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        BrandModel::destroy($id);
        flash()->success(__('dashboard_success.model_deleted'));
        return redirect()->route('models.index');
    }

}
