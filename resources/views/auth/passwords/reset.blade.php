@extends('layouts.app')
@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')


    <div class="reset-container">
        <h1>{{ __('Reset Password') }}</h1>

        <div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password" required
                           autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password">
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn_green">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection
