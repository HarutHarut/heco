<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\DetailRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DetailController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $details = Detail::when($search, function ($query) use ($search) {
            $query->where('key', 'LIKE', "%{$search}%");
        })->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.details.index', compact('details'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.details.create');
    }


    /**
     * @param DetailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DetailRequest $request)
    {
        Detail::create([
            'key' => $request->key,
            'is_show' => $request->is_show
        ]);
        flash()->success(__('dashboard_success.brand_created'));

        return redirect()->route('details.index');
    }


    /**
     * @param DetailRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DetailRequest $request, $id)
    {
        Detail::find($id)->update([
            'key' => $request->key,
            'is_show'=>$request->is_show ?? 0
        ]);
        flash()->success(__('dashboard_success.dike_updated'));
        return redirect()->route('details.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $detail = Detail::find($id);
        return view('dashboard.details.edit', compact('detail'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Detail::destroy($id);
        flash()->success(__('dashboard_success.detail_deleted'));
        return redirect()->route('details.index');
    }

}
