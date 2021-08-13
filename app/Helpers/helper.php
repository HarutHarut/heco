<?php

use App\Models\Bike;
use App\Models\NewBikeRequest;
use Illuminate\Support\Collection;

/**
 * @return mixed
 */
function m_locale()
{
    return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}


function m_lang_icon_path($lang = null): string
{
    switch ($lang) {
        case 'en':
            return '/img/united-states.svg';
        case  'de':
            return '/img/germany.svg';
        default:
            return '/img/united-states.svg';
    }
}

function active_link($path = '', $prefix = '/dashboard')
{
    $path = $path ? '/' . $path : '';
    return Request::is(LaravelLocalization::getCurrentLocale() . $prefix . $path);
}

function notifications()
{

    $data = Bike::where('request', Bike::REQUEST_TRUE)->where('send_request', Bike::SEND_REQUEST)->orderBy('id', 'DESC')->limit(10)->get();
    $newBike = NewBikeRequest::where('status', NewBikeRequest::REQUEST)->orderBy('id', 'DESC')->limit(10)->get();

    $collection = new Collection($data);
    $requests['data'] = $collection->merge($newBike)->sortByDesc('created_at');

    $requests['count'] = Bike::where('request', Bike::REQUEST_TRUE)->where('send_request', Bike::SEND_REQUEST)->count() + NewBikeRequest::where('status', NewBikeRequest::REQUEST)->count();
    return $requests;
}


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
