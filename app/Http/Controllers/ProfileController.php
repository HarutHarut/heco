<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikeCategory;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Category;
use App\Models\Detail;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use App\Services\ImageService;
use App\Services\ImagesService;
use Carbon\Carbon;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('profile.personal-information', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function notifications()
    {
        $collaps_recivient = Message::where('read_at', '==', '0')->exists();
        $collaps_sender = Message::where('read_at', '==', '2')->exists();
        Message::where('recivient_id', Auth::id())->where('read_at', 0)->update(['read_at' => 1]);
        Message::where('sender_id', Auth::id())->where('read_at', 2)->update(['read_at' => 1]);

        $offers = Message::with('bike.brand')->where('recivient_id', Auth::id())
            ->orWhere('sender_id', Auth::id())->orderBy('id', 'desc')->paginate(50);

        return view('profile.notifications', compact('offers', 'collaps_recivient', 'collaps_sender'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_notification(Request $request)
    {
        Message::destroy($request->get('id'));
        flash()->error('Notification Deleted');
        return back();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function published_bicycles()
    {
        $bikes = Bike::where('user_id', Auth::user()->id)
            ->where('parent_id', 0)->where('status', '!=', 'deleted')->where('send_request', 1)->get();

        $countes = Message::select('bike_id', DB::raw('count(*) as count'))
            ->groupBy('bike_id')
            ->get()
            ->toArray();
        return view('profile.published', compact('bikes', 'countes'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function favorites()
    {
        $bike_id = Favorite::where('user_id', Auth()->id())->pluck('bike_id');
        $bikes = Bike::whereIn('id', $bike_id)
            ->where('status', 'active')
            ->where('parent_id', 0)
            ->where('send_request', 1)
            ->get();
        return view('profile.favorites', compact('bikes'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function my_purchases()
    {
        $bookings = Auth::user()->bookings()->whereIn('status', ['paid', 'success'])->get();

        return view('profile.purchases', compact('bookings'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function booking_destroy($id)
    {
        Booking::destroy($id);
        flash()->error('Booking Deleted');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish_destroy($id)
    {
        try {
            $bike = Bike::find($id);
            $bike->update(['status' => 'deleted']);
            flash()->error('Bike Deleted');
        } catch (\Throwable $exception) {
            flash()->error('Can\'t delete this bike');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favorites_destroy($id)
    {
        $favorite_id = Favorite::where('bike_id', $id)->where('user_id', Auth()->id())->pluck('id');
        Favorite::destroy($favorite_id);
        flash()->error('Favorite Deleted');
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eye_colaps(Request $request)
    {
        $bike = Bike::findOrFail($request->id);
        $status = $bike['status'];
        if ($status == 'active') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }
        $bike->update([
            'status' => $status,
        ]);

        flash()->success(__('Your profile is updateed!'));
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function change_password()
    {
        return view('profile.change-password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password_update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $validator->after(function ($validator) use ($data) {
            if (!Hash::check($data['old_password'], Auth::user()->password)) {
                $validator->errors()->add('old_password', 'The password does not match.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        Auth::user()->update(['password' => Hash::make($data['password'])]);
        flash()->success(__('Your password has been changed successfully'));
        return back();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit_bike(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|gt:0',
            'bike_id' => 'required'
        ]);

        $bike = Bike::find($request->get('bike_id'));
        $bike->update([
            'price' => $request->get('price'),
        ]);
        return response()->json('Your price  changed', 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'country' => 'max:255',
            'city' => 'max:255',
            'street' => 'max:255',
            'house_number' => 'max:255',
            'zip' => 'max:255',
        ]);
        $old_email = $user->email;
        if($old_email != $request->get('email')){
            $user->email_verified_at = null;
            $user->save();
        }

        $data = $request->all();
        $data['birth_date'] = Carbon::createFromFormat('d m Y',
            $data['day'] . ' ' . $data['month'] . ' ' . $data['year']);
        $user->update($data);

        if($old_email != $request->get('email')){
            $user->sendEmailVerificationNotification();
            flash()->success(__('Please verify your new email address'));
        }
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile_picture_update(Request $request)
    {
        $user = Auth::user();
        $image_path = $user->image_path;

        if ($image_path) {
            Storage::delete('/public/user_image/' . $image_path);
        }

        ImagesService::saveCropImage($request->image, $user, 'user_image/' . $user->id, 'image_path');
        return response()->json(['status' => 'success'], 200);
    }


    /**
     * @param Request $request
     */
    public function compare(Request $request)
    {
        $id = (int)$request->get('id');

        $bike_ids = Session::get('bike_ids', []);

        if (array_key_exists($id, $bike_ids)) {
            unset($bike_ids[$id]);
        } else {
            $bike_ids[$id] = $id;
        }
        if (count($bike_ids) > 2) {
            return response()->json('error', 422);
        }

        Session::put('bike_ids', $bike_ids);

        return response()->json([
            'count' => count($bike_ids),
            'bike_ids' => Session::get('bike_ids')
        ], 200);
    }

}
