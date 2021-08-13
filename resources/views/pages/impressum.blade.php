@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="terms-privacy">

        <div class="terms-privacy-container">
            <h1>{{ $impressum->data->title ?? '' }}</h1>
            <p>{{ $impressum->data->short_description ?? ''}}</p>
            {!!  $impressum->data->description ?? '' !!}
        </div>

    </section>

@endsection

