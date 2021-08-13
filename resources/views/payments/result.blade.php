@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="terms-privacy">

        <div class="terms-privacy-container">
            @if($type == 'success')
                <h1>{{__('Thank you for payment')}}</h1>
                <p>{{__('payment text')}}</p>
            @else
                <h1>{{__('Something was wrong')}}</h1>
            @endif
        </div>


    </section>

@endsection
