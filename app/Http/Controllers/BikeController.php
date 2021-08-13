<?php

namespace App\Http\Controllers;

use App\Http\Requests\BikeRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\RecommendationBikeRequest;
use App\Http\Requests\SellAddressRequest;
use App\Models\Bike;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Detail;
use App\Models\Image;
use App\Models\NewBikeRequest;
use App\Services\DataService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class BikeController extends Controller
{

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function new_bike(BikeRequest $request, $id)
    {
        $bike = Bike::find($id);
        $bike_settings = BikeSetting::where('bike_id', $id)->get();
        $details = Detail::all();
        $user = Auth::user();
        $data_bike = [
            'frame_size' => $request->frame_size,
            'condition' => $request->condition,
            'color' => $request->color,
            'city' => $request->location,
            'price' => $request->price,
            'bargain' => $request->fixed,
            'milage' => $request->milage,
            'last_service' => $request->last_service,
            'preowned' => $request->preowned,
            'shipping' => $request->shipping,
            'location' => $request->location,
            'user_id' => Auth::id(),
            'info' => $request->info,
            'request' => 1
        ];

        $bike->update($data_bike);
        foreach ($details as $item) {
            $detail = 'details' . $item->id;
            $setting = BikeSetting::where('bike_id', $id)->where('detail_id', $item->id)->first();
            if ($setting) {
                $setting->update([
                    'status' => $request->get($item->id) ?? 0,
                    'note' => $request->get($detail),
                ]);
            } else {
                if ($request->get($item->id) == Bike::STATUS_DETAIL_CHANGED) {
                    BikeSetting::create([
                        'note' => $request->get($detail),
                        'detail_id' => $item->id,
                        'bike_id' => $id,
                        'status' => $request->get($item->id) ?? 0,
                    ]);
                } else {
                    BikeSetting::create([
                        'value' => $request->get($detail),
                        'detail_id' => $item->id,
                        'bike_id' => $id,
                        'status' => $request->get($item->id) ?? 0,
                    ]);
                }

            }
        }
        Mail::send('emails.new_bike', [
            'user' => $user,
            'bike' => $bike,
            'type' => '',
        ], function ($m) use ($request) {
            $m->to(config('mail.adminmail'))->subject(__('New Selling Bike Request'));
        });
        if ($user->city && $user->state && $user->zip && $user->house_number && $user->street) {
            Mail::send('emails.new_bike', [
                'user' => $user,
                'bike' => $bike,
                'type' => 'seller'
            ], function ($m) use ($user) {
                $m->to($user->email)->subject(__('New Selling Bike'));
            });
            flash()->success(__('Thank you for your request Our team will confirm it within 24 hours'));
            return redirect()->route('shop.index');
        }
        return redirect()->route('sell.address', $bike->id);
    }

    /**
     * @param BikeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit_bike(BikeRequest $request, $id)
    {
        $bike = Bike::find($id);

        $bike_settings = BikeSetting::where('bike_id', $id)->get();
        $details = Detail::where('is_show', 1)->get();

        $data_bike = [
            'frame_size' => $request->frame_size,
            'condition' => $request->condition,
            'color' => $request->color,
            'city' => $request->location,
            'price' => $request->price,
            'bargain' => $request->bargain,
            'milage' => $request->milage,
            'last_service' => $request->last_service,
            'preowned' => $request->preowned,
            'shipping' => $request->shipping,
            'location' => $request->location,
            'info' => $request->info,
        ];

        $bike->update($data_bike);

        foreach ($details as $item) {
            $detail = 'details' . $item->id;
            $setting = BikeSetting::where('bike_id', $id)->where('detail_id', $item->id)->first();
            if ($setting) {
                $setting->update([
                    'status' => $request->get($item->id) ?? 0,
                    'note' => $request->get($detail),
                ]);
            } else {
                if ($request->get($item->id) == Bike::STATUS_DETAIL_CHANGED) {
                    BikeSetting::create([
                        'note' => $request->get($detail),
                        'detail_id' => $item->id,
                        'bike_id' => $id,
                        'status' => $request->get($item->id) ?? 0,
                    ]);
                } else {
                    BikeSetting::create([
                        'value' => $request->get($detail),
                        'detail_id' => $item->id,
                        'bike_id' => $id,
                        'status' => $request->get($item->id) ?? 0,
                    ]);
                }

            }
        }
        return redirect()->route('published-bicycles');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function address($id)
    {
        $bike = Bike::findOrFail($id);
        $user = \auth()->user();
        return view('bikes.address', compact('bike', 'user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addressStore($id, SellAddressRequest $request)
    {
        $bike = Bike::findOrFail($id);
        $user = \auth()->user();
        $user->update($request->all());
        flash()->success(__('Thank you for your request Our team will confirm it within 24 hours'));
        Mail::send('emails.new_bike', [
            'user' => Auth::user(),
            'bike' => $bike,
            'type' => 'seller'
        ], function ($m) use ($user) {
            $m->to($user->email)->subject(__('New Selling Bike'));
        });
        return redirect()->route('shop.index');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function buy()
    {
        (new SeoService())->seoForPage('buy');
        return view('bikes.buy');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function sell()
    {
        $years = Bike::orderBy('year', 'desc')->groupBy('year')->pluck('year')->toArray();
        $brands = Brand::all();
        (new SeoService())->seoForPage('sell-1');
        return view('bikes.sell', [
            'years' => $years,
            'brands' => $brands,
            'models' => collect([]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function select(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'year' => 'numeric|nullable'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $brand_id = $request->get('brand');
        $model_id = $request->get('model');
        if ($request->get('search')) {
            $bikes = Bike::with('category')
                ->where(function ($query) use ($request) {
                    foreach (explode(' ', trim($request->get('search'))) as $item){
                        $query->where('name', 'LIKE', '%' . $item . '%');
                    }
                    return $query;
                })
                ->when($request->get('search_year'), function ($query) use ($request){
                    return $query->where('year', $request->get('search_year'));
                })
                ->where('parent_id', 1)
                ->where('status', 'active')
                ->paginate(40);
        } else {
            $bikes = Bike::with('category')
                ->when($brand_id, function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                })
                ->when($model_id, function ($query) use ($model_id) {
                    return $query->where('brand_model_id', $model_id);
                })
                ->when($request->get('year'), function ($query) use ($request) {
                    return $query->where('year', $request->get('year'));
                })
                ->where('parent_id', 1)
                ->where('status', 'active')
                ->paginate(40);
        }

        $bike_id = $bikes->pluck('id');

        if($request->ajax()){
            return view('bikes._select_bikes', compact('bikes'));
        }

        return view('bikes.select', compact('bikes'));
    }

    /**
     * @param Request $request
     * @param int $bike_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectStore(Request $request, int $bike_id)
    {
        $data = $request->all();
        $bike = Bike::where('id', $bike_id)->first();

        $bike_settings = BikeSetting::where('bike_id', $bike_id)->get();
        $values = BikeSetting::where('bike_id', $bike_id)->pluck('value');
        $detail_id = BikeSetting::where('bike_id', $bike_id)->pluck('detail_id');
        $details = Detail::whereIn('id', $detail_id)->pluck('key');

        $count = count($bike_settings);
        $new_bike = Bike::create([
            'name' => $bike->model->name ?? '',
            'slug' => DataService::getSlug($bike->model->name),
            'status' => 'pending',
            'year' => $bike->year,
            'brand_id' => $bike->brand_id,
            'msrp' => $bike->msrp,
            'weight' => $bike->weight,
            'image_path' => $bike->image_path,
            'description' => $bike->description,
            'user_id' => Auth::id(),
            'brand_model_id' => $bike->brand_model_id,
            'token' => generateRandomString(32),
            'request' => 0,
            'bike_id' => $bike->id
        ]);

        $new_bike->addQR();
        $new_bike->category()->sync($bike->category);
        $old_bike_id = $bike_id;
        $bike_id = $new_bike->id;
        foreach ($bike_settings as $item) {
            $new_bike_settings = BikeSetting::create([
                'bike_id' => $bike_id,
                'detail_id' => $item['detail_id'],
                'value' => $item['value']
            ]);
        }

        return redirect()->route('sell.condition', ['bike_id' => $new_bike->id]);
    }

    /**
     * @param $bike_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function condition($bike_id)
    {
        return view('bikes.condition', compact('bike_id'));
    }

    /**
     * @param $bike_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function conditionStore($bike_id, Request $request)
    {
        $bike = Bike::findOrFail($bike_id);
        $bike->update([
            'condition' => $request->get('condition'),
        ]);

        return redirect()->route('sell.components', $bike_id);
    }

    /**
     * @param $bike_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function components($bike_id)
    {
        $bike = Bike::findOrFail($bike_id);
        $old_bike = $bike->parent;
        $years = date('Y') - $old_bike->year;
        if($years < 0){
            $years = 0;
        }
        if($years > 30){
            $years = 30;
        }
        $condition = $bike->condition;
        $min = config("condition.$condition.min") ?? '';
        $max = config("condition.$condition.max") ?? '';

        $price_min = $old_bike->msrp * $min[$years] / 100;
        $price_max = $old_bike->msrp * $max[$years] / 100;
        $price_min = round($price_min, 2);
        $price_max = round($price_max, 2);

        $avg_price = Bike::avg('msrp');
        return view('bikes.components', compact('bike', 'avg_price', 'old_bike', 'price_min', 'price_max'));
    }

    /**
     * @param int $bike_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function images(int $bike_id)
    {
        $bike = Bike::find($bike_id);
        return view('bikes.images', compact('bike', 'bike_id'));
    }

    /**
     * @param ImageRequest $request
     * @param int $bike_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imagesStore(ImageRequest $request, int $bike_id)
    {
        $bike = Bike::find($bike_id);
        return redirect()->route('sell.information', $bike_id);
    }

    /**
     * @param int $bike_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function information(int $bike_id)
    {
        $bike = Bike::find($bike_id);
        $bike->image_path = $bike->images[0]->path;
        $bike->save();
        $details = Detail::where('is_show', 1)->get();
        return view('bikes.information', compact('bike', 'details'));
    }

    /**
     * @param int $bike_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editInformation(int $bike_id)
    {
        $bike = Bike::where('user_id', Auth::id())->where('id', $bike_id)->firstOrFail();
        $details = Detail::where('is_show', 1)->get();
        return view('bikes.edit_information', compact('bike', 'details'));
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function mobileImages($token)
    {
        $bike = Bike::where('token', $token)->firstOrFail();
        return view('bikes.mobile_images', compact('bike'));
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function mobileImagesUpload($id, Request $request)
    {
        $bike = Bike::findOrFail($id);

        if ($request->get('type') == 'defects[]') {
            Image::where('type', 'defects')->where('imageable_id', $bike->id)
                ->where('imageable_type', Bike::class)->delete();
            foreach ($request->defects as $defect) {
                $bike->saveImage($defect, 'defects');
            }
        } else {
            $bike->saveImage($request->file($request->get('type')), $request->get('type'));
        }

        return response()->json(['status' => 'sucess'], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function mobileImagesGet($id)
    {
        $bike = Bike::findOrFail($id);
        return view('bikes._mobile_images', compact('bike'));
    }


    /**
     * @param Request $request
     */
    public function mobileImagesDestroy(Request $request)
    {
        Image::destroy($request->get('image_id'));

        return response()->json(['status' => 'sucess'], 200);
    }


    /**
     * @param RecommendationBikeRequest $request
     */
    public function add_my_bike(RecommendationBikeRequest $request)
    {
        $data = $request->all();
        $email = $data['email_recomm'];
//dd($data);
        NewBikeRequest::create([
            "brand" => $request->get('brand_recomm'),
            "model" => $request->get('model_recomm'),
            "year" => $request->get('year_recomm'),
            "email" => $request->get('email_recomm'),
            'lang_message' => LaravelLocalization::getCurrentLocale()
        ]);
        Mail::send('emails.new_bike_recommendation', [
            'data' => $data,
        ], function ($m) use ($request) {
            $m->to(config('mail.adminmail'))->subject(__('New bike model request'));
        });
        flash()->success(__('Your request has been sent for approval'));

    }

    /**
     * @param Request $request
     * @param $brend_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_models(Request $request, $brend_id)
    {
        $brend_id = explode(',', $brend_id);
        $model_ids = Bike::when($request->get('year'), function ($query) use ($request){
            return $query->where('year', $request->get('year'));
        })->whereIn('brand_id', $brend_id)->groupBy('brand_model_id')
            ->pluck('brand_model_id')->toArray();
        $models = BrandModel::whereIn('id', $model_ids)->get();
        return response()->json($models);
    }

    /**
     * @param Request $request
     * @param $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_brands(Request $request, $year)
    {
        $brand_ids = Bike::where('year', $year)->groupBy('brand_id')->pluck('brand_id')->toArray();
        $brands = Brand::whereIn('id', $brand_ids)->get();
        return response()->json($brands);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function compaire()
    {
        $bike_ids = Session::get('bike_ids') ?? [];
        $bikes = Bike::whereIn('id', $bike_ids)->get() ?? [];

        $bike_1 = $bikes[0] ?? null;
        $bike_2 = $bikes[1] ?? null;

        $details = Detail::all();

        return view('bikes.compare', compact('bike_1', 'bike_2', 'details'));
    }
}
