@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')

<section class="buy-1">
    <div class="buy-1-container">
        <div class="buy-1-item">
            <div class="buy-1-item-text">
                <p>{{__('Show me whats in Stock Browse through all bikes')}}</p>
                <a href="{{ route('shop.index') }}" class="btn btn_green">{{__('Browse all bikes')}}</a>
            </div>
            <picture>
                <source srcset="/img/buy-2-2.webp" type="image/webp">
                <source srcset="/img/buy-2-2.png" type="image/png">
                <img alt="buy-2" src="/img/buy-2-2.png"  width="351" height="455">
            </picture>
        </div>
        <div class="buy-1-item">
            <div class="buy-1-item-text">
                <p>{{__('I know exactly what I want Filter by make and model')}}</p>
                <a href="{{ route('shop.structured') }}" class="btn btn_green">{{__('Structured Search')}}</a>
            </div>
            <picture>
                <source srcset="/img/buy-1-2.webp" type="image/webp">
                <source srcset="/img/buy-1-2.png" type="image/png">
                <img src="/img/buy-1-2.png" alt="" width="351" height="455">
            </picture>
        </div>
        <div class="buy-1-item buy-1-item-coming">
            <div class="buy-1-item-text">
                <a href="#" class="btn btn_green">{{__('Guided Search')}}</a>
            </div>
            <span>{{__('Coming soon!')}}</span>
            <picture>
                <source srcset="/img/buy-3-2.webp" type="image/webp">
                <source srcset="/img/buy-3-2.png" type="image/png">
                <img src="/img/buy-3-2.jpg" alt="" width="351" height="455">
            </picture>
        </div>
    </div>
</section>

@endsection

