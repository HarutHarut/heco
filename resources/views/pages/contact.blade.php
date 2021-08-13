@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="contact-page">

        <div class="contact-container">
            <h1 class="w-100">{{__('Contact Us')}}</h1>

            <div class="contact-form">
                <p>{{__('contact us text')}}
                </p>
                <form action="{{ route('contact.mail') }}" method="POST" id="contact-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" placeholder="{{__('Name')}}" name="name" class="form-control  @error('name') is-invalid @enderror" aria-label="{{__('Name')}}" value="">
                        @error('name')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="{{__('E-mail')}}" name="email" class="form-control @error('email') is-invalid @enderror" aria-label="{{__('E-mail')}}" value="">
                         @error('email')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Message"></textarea>
                         @error('message')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-md-right position-relative">
                        <div class="g-recaptcha" data-callback="imNotARobot" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                        <button class="btn btn_green mt-22 recaptcha-disabled" disabled data-action='submit'>{{__('Send')}}</button>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </form>
            </div>
            <div class="contact-info">
                <h2>{{__('Info')}}</h2>
                <address class="mb-0">
                    <div class="address-item">
                        <p>{{__('Phone')}}</p>
                        <a href="tel:{{__('+49 172 4582838')}}" class="mr-2">{{__('+49 172 4582838')}}</a>
                    </div>
                    <div class="address-item d-flex align-items-start">
                        <div class="address-item-info">
                            <p>{{__('Email')}}</p>
                            <a href="mailto:{{__('info@buycycle.de')}}" class="mr-2">{{__('info@buycycle.de')}}</a>
                        </div>
                    </div>
                    <div class="address-item d-flex align-items-start">
                        <div class="address-item-info">
                            <p>{{__('Address')}}</p>
                            <span>Ansbacher Str. 5</span><br>
                            <span>{{__('80796 Munich')}}</span><br>
                            <span>{{__('Germany')}}</span>
                        </div>
                    </div>
                </address>
                <div class="footer-follow">
                    <p>{{__('Follow us at')}}</p>
                    <div class="footer-socials d-flex">
                        <a href="https://www.facebook.com/buycyclede-108366184681694" rel="noreferrer" target="_blank" title="" aria-label="facebook" data-toggle="tooltip"
                           data-original-title="facebook">
                            <img src="/img/facebook.svg" alt="facebook" class="opacity-img" loading="lazy" width="17" height="17">
                        </a>
                        <a href="https://www.instagram.com/buycycle_de/" rel="noreferrer" target="_blank" title="" aria-label="instagram" data-toggle="tooltip"
                           data-original-title="instagram">
                            <img src="/img/instagram.svg" alt="instagram" class="opacity-img" loading="lazy" width="17" height="17">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-bg">
            <img src="/img/contact-bike.png" alt="contact">
        </div>
    </section>

@endsection
