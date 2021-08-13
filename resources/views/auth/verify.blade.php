@extends('layouts.app')
@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="reset-container" style="min-height: 50vh;">

        <h1>{{ __('Verify Your Email Address') }}</h1>

        <div>


            <p style="margin-bottom: 30px">{{ __('Before proceeding, please check your email for a verification link') }}
                {{ __('If you did not receive the email') }}
            </p>

            <form method="POST" action="{{ route('verification.resend') }}" style="margin-bottom: 30px">
                @csrf
                <button type="submit" class="btn btn_green">{{ __('click here to request another') }}</button>
            </form>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address') }}
                </div>
            @endif
        </div>
    </div>
@endsection
