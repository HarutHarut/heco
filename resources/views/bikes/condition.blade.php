@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="sell-4">
        <picture class="sell-3-bg">
            <source srcset="/img/sell-4-bg.webp" type="image/webp">
            <source srcset="/img/sell-4-bg.jpg" type="image/jpg">
            <img src="/img/sell-4-bg.jpg" alt="sell" width="1920" height="1237" loading="lazy">
        </picture>

        <h1>{{__('Select the condition your bike is in')}}</h1>

        <div class="sell-4-container">

            <div class="sell-4-item">
                <h2>
                    <span class="color-excellent">{{__('Very Good')}}</span><br>
                    <span>{{__('3% of Bikes')}}</span>
                </h2>
                <p>{{__('Excellent_text')}}</p>
                <form action="{{route('sell.condition.store', $bike_id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="condition" value="{{config('enums.CONDITION.Very Good')}}">
                    <button type="submit" class="btn btn_green">{{__('Lets go')}}</button>
                </form>                    </div>
            <div class="sell-4-item">
                <h2>
                    <span class="color-very-good">{{__('Good')}}</span><br>
                    <span>{{__('23% of Bikes')}}</span>
                </h2>
                <p>{{__('Very_Good_text')}}</p>
                <form action="{{route('sell.condition.store', $bike_id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="condition" value="{{config('enums.CONDITION.Good')}}">
                    <button type="submit" class="btn btn_green">{{__('Lets go')}}</button>
                </form>
            </div>
            <div class="sell-4-item">
                <h2>
                    <span class="color-good">{{__('OK')}}</span><br>
                    <span>{{__('54% of Bikes')}}</span>
                </h2>
                <p>{{__('Good_text')}}</p>
                <form action="{{route('sell.condition.store', $bike_id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="condition" value="{{config('enums.CONDITION.OK')}}">
                    <button type="submit" class="btn btn_green">{{__('Lets go')}}</button>
                </form>
            </div>
            <div class="sell-4-item">
                <h2>
                    <span class="color-fair">{{__('Poor')}}</span><br>
                    <span>{{__('18% of Bikes')}}</span>
                </h2>
                <p>{{__('Fair_text')}}</p>
                <form action="{{route('sell.condition.store', $bike_id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="condition" value="{{config('enums.CONDITION.Poor')}}">
                    <button type="submit" class="btn btn_green">{{__('Lets go')}}</button>
                </form>
            </div>
        </div>

    </section>

@endsection


