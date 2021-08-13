<?php

namespace App\Http\Controllers;

use App\Http\Requests\BikeRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\RecommendationBikeRequest;
use App\Models\Bike;
use App\Models\BikeCategory;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Detail;
use App\Models\Image;
use App\Models\NewBikeRequest;
use App\Models\Page;
use App\Services\DataService;
use App\Services\SeoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function whatWeDo()
    {
        (new SeoService())->seoForPage('what-we-do');
        return view('pages.what_we_do');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function privacy()
    {
        $privacy = Page::where('slug', 'Privacy Policy')->first();
        (new SeoService())->seoForPage('privacy');
        return view('pages.privacy', compact('privacy'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function terms()
    {
        $terms = Page::where('slug', 'Terms')->first();
        (new SeoService())->seoForPage('terms');
        return view('pages.terms', compact('terms'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function impressum()
    {
        $impressum = Page::where('slug', 'Impressum')->first();
        (new SeoService())->seoForPage('impressum');
        return view('pages.impressum', compact('impressum'));
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about()
    {
        (new SeoService())->seoForPage('about');
        return view('pages.about');
    }

}
