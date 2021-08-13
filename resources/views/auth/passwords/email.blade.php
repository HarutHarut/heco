@extends('layouts.app')
@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="reset-container">
        <h1 class="text-center">{{ __('Reset Password') }}</h1>

        <div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn_green">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>

        </form>
    </div>
    </div>

@endsection
