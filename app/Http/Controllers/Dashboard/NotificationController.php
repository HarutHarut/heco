<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\BikeRequest;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Country;
use App\Models\Detail;
use App\Models\Image;
use App\Models\NewBikeRequest;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NotificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $search = $request->get('search', null);

        $bikes = Bike::where('request', Bike::REQUEST_TRUE)->when($search, function ($query) use ($search) {
            $query->where(function ($x) use ($search) {
                $x->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('model', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhere(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('year', 'LIKE', "%{$search}%")
                        ->orWhere('id', 'LIKE', "%{$search}%");
                });
            });
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->where('status', '!=', 'deleted')->sortable()->paginate(10);

        return view('dashboard.notifications.index', compact('bikes'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $bike = Bike::with('user')->find($id);
        $bike->update([
            'send_request' => $request->type == 'approved' ? 1 : -1
        ]);
        try {
            App::setLocale(Bike::find($id)->user->lang_message);
            Mail::send('emails.new_bike_request', [
                'data' => $bike,
                'type' => 'rejected1',
            ], function ($m) use ($bike) {
                $m->to($bike->user->email)->subject(__('Bike Request rejected'));
            });
        } catch (\Exception $e) {

        }
        App::setLocale(LaravelLocalization::getCurrentLocale());
        flash()->success(__('dashboard_success.bike_rejected'));

        return redirect()->route('notifications.index', ['page' => $request->page]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Bike::find($id)->update(['status' => 'deleted']);
        flash()->success(__('dashboard_success.Bike deleted!'));
        return back();
    }
}
