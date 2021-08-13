<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikeCategory;
use App\Models\BikeSetting;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Component;
use App\Models\Detail;
use App\Models\Favorite;
use App\Models\Filter;
use App\Models\Message;
use App\Models\User;
use App\Models\UserComents;
use App\Models\ViewedBicycle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $brand_ids = json_decode($request->get('brand_ids')) ?? [];

        if (isset($brand_ids[0]) && is_array($brand_ids[0])) {
            $brand_ids = $brand_ids[0];
        }
        $model_ids = json_decode($request->get('model_ids')) ?? [];
        if (isset($model_ids[0]) && is_array($model_ids[0])) {
            $model_ids = $model_ids[0];
        }

        $years = Bike::orderBy('year')->groupBy('year')->pluck('year')->toArray();
        $sizes = Bike::orderBy('frame_size')->groupBy('frame_size')->whereNotNull('frame_size')->pluck('frame_size')->toArray();
        $selectedBrands = Brand::where('id', $brand_ids)->get();
        $selectedModels = BrandModel::where('id', $model_ids)->get();
        $brands = Brand::where('name', '!=', '')
            ->orWhereNull('name')
            ->get();
        $component = Component::all();
        $categories = config('enums.CATEGORY');
        $frame_materials = config('enums.FrameMaterial');
        $brake_types = config('enums.BrakeType');
        $shifters = config('enums.SHIFTING');
        $filterSave = Filter::where('user_id', Auth::id())->exists();
        $user = Auth::user();

        $emailVerified = false;

        if (auth()->check()) {
            if ($user->email_verified_at !== null) {
                $emailVerified = true;

            }
        }

        $jsonData = [
            'condition' => json_decode($request->condition) ?? [],
            'search' => json_decode($request->search) ?? '',
            'color' => json_decode($request->color),
            'brand_ids' => json_decode($request->brand_ids),
            'model_ids' => json_decode($request->model_ids),
            'year' => json_decode($request->year),
        ];

        $color = config('enums.colors');

        return view('shop.index', [
            'brands' => $brands,
            'selectedBrands' => $selectedBrands,
            'selectedModels' => $selectedModels,
            'brand_ids' => $brand_ids,
            'model_ids' => $model_ids,
            'years' => $years ?? collect([]),
            'component' => $component ?? collect([]),
            'categories' => $categories ?? collect([]),
//            'year' => $year,
            'jsonData' => $jsonData,
            'sizes' => $sizes ?? collect([]),
            'models' => collect([]),
            'frame_materials' => $frame_materials ?? collect([]),
            'brake_types' => $brake_types ?? collect([]),
            'shifters' => $shifters ?? collect([]),
            'color' => $color ?? collect([]),
            'filterSave' => $filterSave,
            'emailVerified' => $emailVerified
        ]);
    }

    /**
     * @param Request $request
     * @param $brend_id
     * @return \Illuminate\Http\JsonResponse\
     */
    public function getFilters(Request $request, $brend_id)
    {
        $brend_id = explode(',', $brend_id);
        $brands = [];

        $models = BrandModel::whereIn('brand_id', $brend_id)->get();
        $years = Bike::where('brand_id', $brend_id)->orderBy('year')->pluck('year');

        $sizes = Bike::whereIn('brand_id', $brend_id)->orderBy('wheels_size')->pluck('wheels_size');

        $bikes = Bike::whereIn('brand_id', $brend_id)->get();

        return response()->json([
            'models' => $models,
            'years' => $years,
            'sizes' => $sizes
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function structured()
    {
        $brands = Brand::all();
        return view('shop.structured-search', [
            'brands' => $brands,
            'models' => collect([]),
            'years' => collect([]),
            'sizes' => collect([]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $categories = $request->category;
        $conditions = $request->condition;
        $search = $request->search;
        $sort = $request->sort;
        $brands = $request->brand_ids;

        if ($brands && !$brands[0]) {
            $brands = [];
        }

        $frame_materials = $request->frame_material;
        $brake_types = $request->brake_type;
        $shifters = $request->shifter;
        $requestColors = $request->get('color', []);
        $colors = [];
        foreach ($requestColors as $requestColor) {
            $colors[] = config("enums.colors.$requestColor");
        }

        $component_ids = $request->get('component_ids', []);

        $models = $request->get('model_ids', []);
        $years = $request->year;
        $sizes = $request->size;

        $min_price = $request->min_price ? $request->min_price : 0;
        $max_price = $request->max_price ? $request->max_price : Bike::max('price');

        $bikes = Bike::with('brand')
            ->where('parent_id', 0)
            ->where('status', 'active')
            ->where('send_request', 1)
            ->when($request->get('search'), function ($query) use ($request){
                return $query->where(function ($q) use ($request) {
                    foreach (explode(' ', trim($request->get('search'))) as $item) {
                        $q->where('name', 'LIKE', '%' . $item . '%')->orWhereHas('brand', function ($qr) use ($item) {
                            return $qr->where('name', 'like', "%$item%");
                        });
                    }
                    return $q;
                });
             });

        if ($brands) {
            $bikes = $bikes->whereIn('brand_id', $brands);
        }

        if (count($models)) {
            $bikes = $bikes->whereIn('brand_model_id', $models);
        }

        if ($years) {
            $bikes = $bikes->whereIn('year', $years);
        }

        if ($sizes) {
            $bikes = $bikes->whereIn('frame_size', $sizes);
        }

        if (count($component_ids)) {
            $bikes = $bikes->whereIn('component_id', $component_ids);
        }

        if ($conditions) {
            $bikes = $bikes->whereIn('condition', $conditions);
        }

        if ($categories) {
            $category = Category::whereIn('name', $categories)->get('id');
            $bikes = $bikes->whereHas('category', function ($q) use ($category) {
                $q->whereIn('category_id', $category);
            });
        }

        if ($frame_materials) {
            $bikes = $bikes->whereHas('details', function ($q) use ($frame_materials) {
                $q->whereIn('value', $frame_materials)->where('detail_id', 1);
            });
        }

        if ($brake_types) {
            $bikes = $bikes->whereHas('details', function ($q) use ($brake_types) {
                $q->whereIn('value', $brake_types)->where('detail_id', 4);
            });
        }

        if ($shifters) {
            $bikes = $bikes->whereHas('details', function ($q) use ($shifters) {
                $q->whereIn('value', $shifters)->where('detail_id', 21);
            });
        }

        if ($colors) {
            $bikes = $bikes->whereIn('color', $colors);
        }

        $bikes = $bikes->whereBetween('price', [$min_price, $max_price]);

        if ($sort == 'min_price') {
            $bikes->orderBy('price', 'ASC');
        } else if ($sort == 'max_price') {
            $bikes->orderBy('price', 'DESC');
        } else {
            $bikes->orderBy('created_at', 'DESC');
        }

        $bikes = $bikes->paginate(18);

        return response()->json([
            'bikes' => $bikes,
            'last_page' => $bikes->lastPage()
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function bike(Request $request, string $slug)
    {
        $message = Message::with('bike')
            ->where('status', '!=', -1)
            ->has('bike')
            ->find($request->get('message_id'));

        if ($message) {
            $bike = $message->bike;
            $price = $message->answer ?? $message->message ?? $bike->price;
        } else {
            $bike = Bike::whereSlug($slug)->firstOrFail();
            $price = $bike->price;
        }

        $bike->count_of_visits = $bike->count_of_visits + 1;
        $bike->save();

        $my_purchases = Booking::where('bike_id', $bike->id)->exists();

        if (Auth::user()) {
            $user_id = Auth::id();
            $veviewedCount = ViewedBicycle::where('user_id', $user_id)->count();
            $veviewed_bike = ViewedBicycle::where('user_id', $user_id)->where('bike_id', $bike->id)->first();
        } else {
            $ip = $request->ip();
            $veviewedCount = ViewedBicycle::where('ip_address', $ip)->count();
            $veviewed_bike = ViewedBicycle::where('ip_address', $ip)->where('bike_id', $bike->id)->first();
        }

        if ($veviewedCount > 4 && !$veviewed_bike) {
            if (Auth::user()) {
                ViewedBicycle::where('user_id', $user_id)->first()->delete();
                $veviewed = ViewedBicycle::create([
                    'bike_id' => $bike->id,
                    'user_id' => $user_id,
                ]);

            } else {
                ViewedBicycle::where('ip_address', $ip)->first()->delete();
                $veviewed = ViewedBicycle::create([
                    'bike_id' => $bike->id,
                    'ip_address' => $ip,
                ]);
            }

        } else {
            if (!$veviewed_bike) {
                if (Auth::user() && $bike->id) {
                    $veviewed = ViewedBicycle::create([
                        'bike_id' => $bike->id,
                        'user_id' => $user_id,
                    ]);

                } else {
                    $veviewed = ViewedBicycle::create([
                        'bike_id' => $bike->id,
                        'ip_address' => $ip,
                    ]);
                }
            }
        }

        if (Auth::user()) {
            $veviewed_ip_bike = ViewedBicycle::where('user_id', $user_id)->pluck('bike_id');
        } else {
            $veviewed_ip_bike = ViewedBicycle::where('ip_address', $ip)->pluck('bike_id');
        }

        $veviewed_bikes = Bike::whereIn('id', $veviewed_ip_bike)
            ->where('parent_id', 0)
            ->where('id', '!=', $bike->id)
            ->where('status', 'active')
            ->where('send_request', 1)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $similar_models = Bike::where('brand_model_id', $bike->brand_model_id)
            ->where('parent_id', 0)
            ->where('id', '!=', $bike->id)
            ->where('status', 'active')
            ->where('send_request', 1)
            ->inRandomOrder()
            ->limit(5)
            ->get();


        $bike->update([
            'recommended_price' => $price,
        ]);

        $details = Detail::where('is_show', 1)->get();

        $comments = Comment::where('commentable_id', $bike->id)->whereNull('parent_id')->get()->sortByDesc("created_at");
        $commentWithAnswers = Comment::with('parent')->get();

        $userComments = UserComents::where('commentable_id', $bike->id)->where('user_id', Auth::id())->pluck('comment_id')->toArray();

        return view('shop.bike', compact('details', 'my_purchases', 'bike', 'similar_models',
            'veviewed_bikes', 'price', 'comments', 'commentWithAnswers', 'userComments'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function countery_offer($id, Request $request)
    {
        $request->validate([
            'price' => 'gt:0'
        ]);
        $bike = Bike::findorFail($id);

        $percent = $bike->price * 0.7;
        if($percent > $request->price){
            flash()->success(__("You offer less than 70% of the cost"));
            return back();
        }elseif ($request->price > $bike->price){
            flash()->success(__("You offer more value"));
            return back();
        }
        $countery_offer = $request->get('price');
        $sender_id = Auth::id();
        $recivient_id = $bike->user_id;

        $user = $bike->user;
        $email = $user->email;

        $messages = Message::where('sender_id', $sender_id)->where('recivient_id', $recivient_id)->where('bike_id', $bike->id)->count();
        if ($messages > 4) {
            flash()->error(__("You cannot send more than five counter offer"));
        } else {
            Message::create([
                'message' => $countery_offer,
                'sender_id' => $sender_id,
                'recivient_id' => $recivient_id,
                'bike_id' => $bike->id,
                'status' => 0
            ]);
            try {
                App::setLocale($user->lang_message);
                Mail::send('emails.notifications', [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'type' => 'Counter offer'
                ], function ($m) use ($email) {
                    $m->to($email)->subject(__('Counter offer'));
                });
            } catch (\Exception $e) {
            }
            flash()->success(__("Thank you! Your price offer has been sent successfully Please wait for the seller's reply"));
        }

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shipping_answer(Request $request)
    {
        $request->validate([
            'answer' => 'gt:0'
        ]);

        $message = Message::findOrFail($request->get('id'));
        $bike = Bike::find($message['bike_id']);

        $user = $message->sender;
        $email = $user->email;
        if ($message->answer) {
            flash()->success(__('You have already sent a message'));
            return back();
        }
        $message->update([
            'answer' => $request->get('answer'),
            'read_at' => 2
        ]);

        try {
            App::setLocale($user->lang_message);
            Mail::send('emails.notifications', [
                'name' => $user->first_name . ' ' . $user->last_name,
                'type' => 'new-request'
            ], function ($m) use ($email) {
                $m->to($email)->subject(__('New counter offer by seller'));
            });
        } catch (\Exception $e) {
        }

//        $bike->update([
//            'status' => 'inactive',
//        ]);

        flash()->success(__('Your answer is send'));

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favorite(Request $request)
    {
        $bike_id = $request->id;
        $favorite = Favorite::where('bike_id', $bike_id)->where('user_id', Auth::id())->first();
        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'bike_id' => $bike_id,
                'user_id' => Auth::id()
            ]);
        }
        $count = Favorite::where('user_id', Auth::id())->whereHas('bike', function ($q) {
            return $q->where('status', 'active');
        })->count();

        return response()->json($count, 200);
    }

    /**
     * @param Request $request
     * @param $brend_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_buy(Request $request, $brend_id)
    {
        $brend_id = explode(',', $brend_id);
        $models = BrandModel::whereIn('brand_id', $brend_id)->get();

        $years = Bike::whereIn('brand_id', $brend_id)->groupBy('year')->orderBy('year')->pluck('year');
        $sizes = Bike::whereIn('brand_id', $brend_id)->orderBy('frame_size')->pluck('frame_size');
        return response()->json(array('models' => $models, 'years' => $years, 'sizes' => $sizes));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dicline_approve(Request $request)
    {
        $data = $request->all();
        $bike = Bike::find($data['bike_id']);
        $approve = $data['approve'] ? 2 : -1;

        $message = Message::find($data['message_id']);
        $message->update([
            'status' => $approve,
            'read_at' => 2
        ]);
        if (!$message->answer) {
            $user = Message::find($data['message_id'])->sender;
        } else {
            $user = Message::find($data['message_id'])->recivient;
        }

        $email = $user->email;
        if ($approve == 2) {
            $bike->update([
                'status' => 'inactive',
            ]);
            try {
                App::setLocale($user->lang_message);
                Mail::send('emails.notifications', [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'type' => 'approved'
                ], function ($m) use ($email) {
                    $m->to($email)->subject(__('Counter offer approwed'));
                });
            } catch (\Exception $e) {
            }
        } else {
            $bike->update([
                'status' => 'active',
            ]);
        }

        if ($approve == -1) {
            if ($message->answer) {
                try {
                    App::setLocale($user->lang_message);
                    Mail::send('emails.notifications', [
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'type' => 'rejected-buyer'
                    ], function ($m) use ($email) {
                        $m->to($email)->subject(__('Counter offer rejection by buyer'));
                    });
                } catch (\Exception $e) {
                }
            } else {
                try {
                    App::setLocale($user->lang_message);
                    Mail::send('emails.notifications', [
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'type' => 'rejected-seller'
                    ], function ($m) use ($email) {
                        $m->to($email)->subject(__('Counter offer rejection'));
                    });
                } catch (\Exception $e) {
                }
            }
        }
        return back();
    }

}
