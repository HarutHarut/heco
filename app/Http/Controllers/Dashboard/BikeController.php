<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\BikeExport;
use App\Http\Requests\Dashboard\BikeRequest;
use App\Imports\Bikeimport;
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
use App\Models\User;
use App\Services\DataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BikeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $parent = $request->get('parent', null);

        $search = $request->get('search', null);
        $category_id = $request->get('category', null);

        $bikes = Bike::withCount('views')->when($category_id, function ($query) use ($category_id) {
            $query->whereHas('category', function ($q) use ($category_id) {
                return $q->where('category_id', $category_id);
            });
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->when($parent, function ($q) use ($parent) {
            if ($parent == 2) {
                $parent = 0;
            }
            return $q->where('parent_id', $parent);
        })->where(function ($q) {
            $q->where('request', 0)
                ->orWhere(function ($q) {
                    $q->where('request', 1)->where('send_request', 1);
                });
        })->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                return $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('year', 'LIKE', "%{$search}%");
            });
        })->where('parent_id', 0)->whereNotIn('status', ['deleted', 'pending'])
            ->sortable()
            ->paginate(10);

        $categories = Category::all();
        return view('dashboard.bikes.index', compact('bikes', 'categories'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $components = Component::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
//        $details = Detail::all();
        $frame_materials = config('enums.FrameMaterial');
        $brake_types = [];
        $brakes_type = config('enums.BrakeType');
        foreach ($brakes_type as $item) {
            $brake_types[$item] = $item;
        }
        $shifters = config('enums.SHIFTING');
        $details = Detail::where('is_show', 1)
            ->where('id', '!=', 21)
            ->where('id', '!=', 4)
            ->where('id', '!=', 6)
            ->where('id', '!=', 1)
            ->get();
        $countries = Country::pluck('country', 'id');

        return view('dashboard.bikes.create', compact('categories', 'components', 'brands', 'details', 'countries', 'brake_types', 'shifters', 'frame_materials'));
    }


    /**
     * @param BikeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BikeRequest $request)
    {
        $data = $this->dataBike($request->all());
        $category_ids = $data['category_ids'] ?? [];
        $data['token'] = generateRandomString(32);
        $bike = Bike::create($data);
        $bike->request = 0;
        if (!isset($request->parent_id)) $bike->send_request = 1;
        $bike->user_id = Auth::id();
        $bike->save();
        $bike->addQR();

        $bike->category()->sync($category_ids);

        $this->imageBike($request->all(), $bike);
        foreach ($request->detail as $key => $item) {
            if ($item['value']) {
                if (!isset($item['status'])) {
                    BikeSetting::create([
                        'bike_id' => $bike->id,
                        'detail_id' => $key,
                        'status' => 0,
                        'value' => $item['value'],
                    ]);
                } else {
                    if ($item['status'] == Bike::STATUS_DETAIL_CHANGED) {
                        BikeSetting::create([
                            'bike_id' => $bike->id,
                            'detail_id' => $key,
                            'status' => $item['status'] ?? 0,
                            'note' => $item['value'],
                        ]);
                    } else {
                        BikeSetting::create([
                            'bike_id' => $bike->id,
                            'detail_id' => $key,
                            'status' => $item['status'],
                            'value' => $item['value'],
                        ]);
                    }
                }
            }
        }
        flash()->success(__('dashboard_success.bike_created'));

        return redirect()->route('bikes.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $components = Component::pluck('name', 'id');
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
//        $details = Detail::where('is_show', 1)->get();
        $frame_materials = config('enums.FrameMaterial');
        $brake_types = [];
        $brakes_type = config('enums.BrakeType');
        foreach ($brakes_type as $item) {
            $brake_types[$item] = $item;
        }
        $shifters = config('enums.SHIFTING');

        $details = Detail::where('is_show', 1)
            ->where('id', '!=', 21)
            ->where('id', '!=', 4)
            ->where('id', '!=', 6)
            ->where('id', '!=', 1)
            ->get();
        $bike = Bike::find($id);
        $countries = Country::pluck('country', 'id');
        $models = BrandModel::where('brand_id', $bike->brand_id)->pluck('name', 'id');


        return view('dashboard.bikes.edit', compact('bike', 'components', 'categories', 'brands', 'details', 'models', 'countries', 'shifters', 'brake_types', 'frame_materials'));
    }


    /**
     * @param BikeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BikeRequest $request, $id)
    {
        $data = $this->dataBike($request->all(), $id);

        $category_ids = $data['category_ids'] ?? [];

        $bike = Bike::find($id);
        if ($request->get('availability')) {
            $data['availability'] = Carbon::parse($request->get('availability'));
        }
        $bike->update($data);

        $this->imageBike($request->all(), $bike);

        $bike->category()->sync($category_ids);

        BikeSetting::where('bike_id', $bike->id)->delete();

        if (isset($request->detail)) {
            foreach ($request->detail as $key => $item) {
                if ($item['value']) {
                    if (isset($item['status']) && $item['status'] == Bike::STATUS_DETAIL_CHANGED) {
                        BikeSetting::create([
                            'bike_id' => $bike->id,
                            'detail_id' => $key,
                            'status' => $item['status'] ?? 0,
                            'note' => $item['value'],
                        ]);
                    } else {
                        BikeSetting::create([
                            'bike_id' => $bike->id,
                            'detail_id' => $key,
                            'status' => $item['status'] ?? 0,
                            'value' => $item['value'],
                        ]);
                    }
                }
            }
        }
        App::setLocale(LaravelLocalization::getCurrentLocale());
        flash()->success(__('dashboard_success.bike_updated'));

        return redirect()->route('bikes.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'category' => $request->category,
            'parent' => $request->parent,
            'search' => $request->search
        ]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        Bike::find($id)->update(['status' => 'deleted']);
        flash()->success(__('dashboard_success.Bike deleted!'));
        return redirect()->route('bikes.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'category' => $request->category,
            'parent' => $request->parent,
            'search' => $request->search
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function brandModels(Request $request)
    {
        $models = BrandModel::where('brand_id', $request->brand_id)->pluck('name', 'id');

        return response()->json([
            'models' => $models
        ], 200);
    }


    /**
     * @param $request
     * @param null $id
     * @return mixed
     */
    public function dataBike($request, $id = null)
    {
        $data = $request;
        if (isset($request['type']) && $request['type'] == 'approved') {
            $data['send_request'] = 1;
            $data['parent_id'] = 0;
            $data['request'] = 1;
            $data['status'] = 'active';
            $bike = Bike::find($id);
            $bike_cnt = $bike->user
                ->sell_bikes()
                ->whereNotIn('status', ['deleted', 'pending'])
                ->count();
            $data['stage'] = ($bike_cnt == 0) ? 'new' : 'ret';
            try {
                App::setLocale($bike->user->lang_message);
                Mail::send('emails.new_bike_request', [
                    'data' => $bike,
                    'type' => 'approved1',
                ], function ($m) use ($bike) {
                    $m->to($bike->user->email)->subject(__('Bike Request approved'));
                });
            } catch (\Exception $e) {

            }

        }
        if (isset($request['type']) && $request['type'] == 'approv') {
            $data['send_request'] = 0;
            $data['request'] = 0;
            $data['status'] = 'active';
            $data['user_id'] = Auth::id();
        }
        if (!isset($request['type'])) {
            $data['status'] = $request['status'] ?? 'inactive';
            $data['shipping'] = $request['shipping'] ?? 0;
            $data['parent_id'] = $request['parent_id'] ?? 0;
            $data['preowned'] = $request['preowned'] ?? 0;
            $data['bargain'] = $request['bargain'] ?? 0;
            if (!isset($request['parent_id'])) $data['send_request'] = 1; else $data['send_request'] = 0;
        }
        $data['msrp_currency'] = 'EUR';
        return $data;
    }


    /**
     * @param $request
     * @param $bike
     */
    public function imageBike($request, $bike)
    {
        if (isset($request['side'])) {
            $bike->saveImage($request['side'], 'side');
        }
        if (isset($request['top'])) {
            $bike->saveImage($request['top'], 'top');
        }
        if (isset($request['crank'])) {
            $bike->saveImage($request['crank'], 'crank');
        }
        if (isset($request['defects'])) {
            Image::where('type', 'defects')->where('imageable_id', $bike->id)->where('imageable_type', Bike::class)->delete();
            foreach ($request['defects'] as $defect) {
                $bike->saveImage($defect, 'defects');
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        set_time_limit(100000);
        Excel::import(new Bikeimport(), request()->file('file'));

        flash()->success(__('dashboard_success.bikes_imported'));
        return back();
    }

    /**
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return (new BikeExport())->download('bikes.xlsx');
    }


}
