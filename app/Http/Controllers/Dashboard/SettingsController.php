<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $settings = Settings::when($search, function ($query) use ($search) {
            $query->where('key', 'like', "%{$search}%");
            $query->orWhere('value', 'like', "%{$search}%");
        })->orderBy('id','DESC')->paginate(10);

        return view('dashboard.settings.index', compact('settings'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.settings.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Settings::create($request->all());
        flash()->success(__('dashboard_success.country_created'));
        return redirect()->route('settings.index');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        Settings::find($id)->update($request->all());
        flash()->success(__('dashboard_success.setting_updated'));
        return redirect()->route('settings.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $setting = Settings::find($id);
        return view('dashboard.settings.edit', compact('setting'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Settings::destroy($id);
        flash()->success(__('dashboard_success.setting_deleted'));
        return redirect()->route('settings.index');
    }

}
