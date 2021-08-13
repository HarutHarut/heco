<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $countries = Country::when($search, function ($query) use ($search) {
            $query->where('country', 'like', "%{$search}%");
        })->orderBy('id','DESC')->paginate(10);

        return view('dashboard.countries.index', compact('countries'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.countries.create');
    }


    /**
     * @param CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CountryRequest $request)
    {
        Country::create($request->all());
        flash()->success(__('dashboard_success.country_created'));
        return redirect()->route('countries.index');
    }


    /**
     * @param CountryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CountryRequest $request, $id)
    {
        Country::find($id)->update($request->all());
        flash()->success(__('dashboard_success.country_updated'));
        return redirect()->route('countries.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $country = Country::find($id);
        return view('dashboard.countries.edit', compact('country'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Country::destroy($id);
        flash()->success(__('dashboard_success.country_deleted'));
        return redirect()->route('countries.index');
    }

}
