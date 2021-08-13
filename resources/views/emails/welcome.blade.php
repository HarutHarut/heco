@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{$name}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <p>{{__('Welcome to buycycle')}}</p>
            <p>{{__('your marketplace for used road bikes')}}</p>
            <p>{{ __('We are happy that you are on board')}}</p>
        </td>
    </tr>
@endsection



