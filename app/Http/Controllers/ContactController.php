<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\PurchaseAdviceRequest;
use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        (new \App\Services\SeoService())->seoForPage('contact');
        return view('pages.contact');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact_mail(ContactRequest $request)
    {
        $data = $request->all();
        Mail::send('emails.contact_us', [
            'data' => $data,
        ], function ($m) use ($request) {
            $m->to(config('mail.adminmail'))->subject(__('Contact Us'));
        });
        flash()->success(__('Your message has been sent successfully'));
        return redirect()->route('home');
    }

    public function purchaseAdvice(PurchaseAdviceRequest $request)
    {
        $data = $request->all();
        $data['url'] = route('shop.bike', $data['slug']);
        Mail::send('emails.purchase-advice', [
            'data' => $data,
        ], function ($m) use ($request) {
            $m->to(config('mail.service_mail'))->subject(__('Purchase Advice'));
        });
        flash()->success(__('Your message has been sent successfully'));
        return 'success';
    }
}
