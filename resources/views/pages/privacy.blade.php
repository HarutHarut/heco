@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="terms-privacy">

        <div class="terms-privacy-container">
            <h1>{{ $privacy->data->title ?? '' }}</h1>
            <p>{{ $privacy->data->short_description ?? ''}}</p>
            {!!  $privacy->data->description ?? '' !!}
        </div>

    </section>

@endsection
