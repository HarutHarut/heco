<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\BikeRequest;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Component;
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

class NewBikeRequestController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $search = $request->get('search', null);

        $requests = NewBikeRequest::when($search, function ($query) use ($search) {
            return $query->where('year', 'LIKE', "%{$search}%")
                ->orWhere('brand', 'LIKE', "%{$search}%")
                ->orWhere('model', 'LIKE', "%{$search}%")
                ->orWhere('id', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%");
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->sortable()->paginate(10);

        return view('dashboard.notifications.request', compact('requests'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $new_bike = NewBikeRequest::find($id);

        if ($request->type == 'rejected') {
            $this->send_mail($new_bike, 'rejected2');

            $new_bike->update([
                'status' => -1
            ]);
            App::setLocale(LaravelLocalization::getCurrentLocale());
            flash()->success(__('dashboard_success.bike_rejected'));
            return redirect()->route('newbike.index', [
                'page' => $request->page,
                'sort' => $request->sort,
                'direction' => $request->direction,
                'search' => $request->search
            ]);

        } else {
            $brand = Brand::updateOrCreate([
                'name' => $new_bike->brand
            ], []);
            $model = BrandModel::updateOrCreate([
                'brand_id' => $brand->id,
                'name' => $new_bike->model
            ], []);

            $bike = Bike::create([
                'name' => $brand->name . ' ' . $model->name,
                'slug' => DataService::getSlug($brand->name . ' ' . $model->name),
                'brand_id' => $brand->id,
                'brand_model_id' => $model->id,
                'year' => $new_bike->year,
                'user_id' => Auth::id(),
                'parent_id' => 1,
                'request' => 0,
                'status' => 'active',
                'token' => generateRandomString(32)
            ]);
            $bike->addQR();
            $new_bike->update([
                'status' => 1
            ]);

            return redirect()->route('DBbikes.edit', [
                $bike->id,
                'type' => 'approv',
                'new_bike' => $new_bike->id
            ]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        NewBikeRequest::destroy($id);
        flash()->success(__('dashboard_success.request_deleted'));
        return redirect()->route('newbike.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'search' => $request->search
        ]);
    }


    /**
     * @param $data
     * @param $type
     * @param null $bike
     */
    public function send_mail($data, $type, $bike = null)
    {
        try {
            $subject = __('New Bike Request');
            if($type == 'rejected2'){
                $subject = __('New Bike Request Rejected');
            }
            App::setLocale($data->lang_message);
            Mail::send('emails.new_bike_request', [
                'data' => $data,
                'type' => $type,
                'bike' => $bike,
            ], function ($m) use ($data, $subject) {
                $m->to($data->email)->subject($subject);
            });
        } catch (\Exception $e) {}
    }

}
