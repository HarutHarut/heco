@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="terms-privacy">

        <div class="terms-privacy-container">
            <h1>{{ $terms->data->title ?? '' }}</h1>
            <p>{{ $terms->data->short_description ?? ''}}</p>
            {!!  $terms->data->description ?? '' !!}
        </div>

    </section>

@endsection
