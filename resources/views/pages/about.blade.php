@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="what-we-do">

        <div class="what-we-do-container">
            <h1 class="font-light">{{__('about_us')}}</h1>
        </div>

        <img src="/img/whats-2-3.jpg" alt="who-we-are" class="w-100">

        <div class="what-we-do-container">
            <p>{{__('about_us_text1')}}</p>
            <p>{{__('about_us_text2')}}</p>
            <p>{{__('about_us_text3')}}</p>
            <p>{{__('about_us_text4')}}</p>
            <p>{{__('about_us_text5')}}</p>
        </div>

    </section>

@endsection
