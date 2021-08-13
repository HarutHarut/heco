<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BikeRequest;
use App\Http\Requests\Dashboard\DBBikeRequest;
use App\Models\Bike;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Component;
use App\Models\Country;
use App\Models\Detail;
use App\Models\Image;
use App\Models\NewBikeRequest;
use App\Services\DataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DBBikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort;

        $search = $request->get('search', null);
        $category_id = $request->get('category', null);

        $bikes = Bike::when($category_id, function ($query) use ($category_id) {
            $query->whereHas('category', function ($q) use ($category_id) {
                return $q->where('category_id', $category_id);
            });
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->where(function ($q) {
            $q->where('request', 0)
                ->orWhere(function ($q) {
                    $q->where('request', 1)->where('send_request', 1);
                });
        })->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search){
                return $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('year', 'LIKE', "%{$search}%");
            });
        })->where('parent_id', 1)
            ->sortable()
            ->paginate(10);


        $categories = Category::all();
        return view('dashboard.DBbikes.index', compact('bikes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $components = Component::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $details = Detail::all();
        $countries = Country::pluck('country', 'id');

        return view('dashboard.DBbikes.create', compact('categories', 'components', 'brands', 'details', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DBBikeRequest $request)
    {
        $data = $request->all();
        $data['slug'] = DataService::getSlug($request['name']);
        $data['send_request'] = 1;
        $data['parent_id'] = 1;
        $data['request'] = 1;
        $data['status'] = 'active';
        $data['msrp_currency'] = 'EUR';

        $category_ids = $data['category_ids'] ?? [];
        $data['token'] = generateRandomString(32);
        $bike = Bike::create($data);
        $bike->request = 0;
        $bike->user_id = Auth::id();
        $bike->save();
        $bike->addQR();

        $bike->category()->sync($category_ids);

        $this->imageBike($request->all(), $bike);

        foreach ($request->detail as $key => $item) {
            if ($item['value']) {
                    BikeSetting::create([
                        'bike_id' => $bike->id,
                        'detail_id' => $key,
                        'value' => $item['value'],
                    ]);
                }

            }


        flash()->success(__('dashboard_success.bike_created'));

        return redirect()->route('DBbikes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $components = Component::pluck('name', 'id');
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $details = Detail::all();
//        $details = Detail::where('id', '!=', 21)
//            ->where('id', '!=', 4)
//            ->where('id', '!=', 6)
//            ->where('id', '!=', 1)
//            ->get();
        $bike = Bike::find($id);
        $countries = Country::pluck('country', 'id');
        $models = BrandModel::where('brand_id', $bike->brand_id)->pluck('name', 'id');
        return view('dashboard.DBbikes.edit', compact('bike', 'components', 'categories', 'brands', 'details', 'models', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DBBikeRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = DataService::getSlug($request['name']);
        $data['send_request'] = 1;
        $data['parent_id'] = 1;
        $data['request'] = 0;
        $data['status'] = 'active';
        $data['msrp_currency'] = 'EUR';

        $category_ids = $data['category_ids'] ?? [];

        $bike = Bike::find($id);
        if ($request->get('availability')) {
            $data['availability'] = Carbon::parse($request->get('availability'));
        }
        $bike->update($data);

        $this->imageBike($request->all(), $bike);

        $bike->category()->sync($category_ids);

        if (!$request->type == 'approved') {
            BikeSetting::where('bike_id', $bike->id)->delete();
        }

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

       if($request->type == 'approv'){
            $new_bike = NewBikeRequest::find($request->new_bike);
            $this->send_mail($new_bike, 'approved2', $bike);
        }

        App::setLocale(LaravelLocalization::getCurrentLocale());
        flash()->success(__('dashboard_success.bike_updated'));

        return redirect()->route('DBbikes.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'category' => $request->category,
            'parent' => $request->parent,
            'search' => $request->search
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $bike = Bike::find($id);
        $bike->delete();
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
     * @param $request
     * @param $bike
     */
    public function imageBike($request, $bike)
    {
        if (isset($request['top'])) {
            $bike->saveImage($request['top'], 'top');
        }
        if (isset($request['side'])) {
            $bike->saveImage($request['side'], 'side');
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
     * @param $data
     * @param $type
     * @param null $bike
     */
    public function send_mail($data, $type, $bike = null)
    {
        try {
            App::setLocale($data->lang_message);
            Mail::send('emails.new_bike_request', [
                'data' => $data,
                'type' => $type,
                'bike' => $bike,
            ], function ($m) use ($data) {
                $m->to($data->email)->subject(__('New Bike Request'));
            });
        } catch (\Exception $e) {}
    }
}
