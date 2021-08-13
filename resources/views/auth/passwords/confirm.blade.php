@extends('layouts.app')
@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="reset-container">
        <h1>{{ __('Confirm Password') }}</h1>

        <div>
            {{ __('Please confirm your password before continuing') }}

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm Password') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
