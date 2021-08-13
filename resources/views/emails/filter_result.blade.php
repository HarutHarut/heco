@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{$user->name}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <h4>{{__('We have new bikes for you')}}</h4>
            <p>{{__('Please check shop page')}}</p>
            <p>{{__('to see bikes please click')}} <a href="{{ route('shop.index') }}" style="color: #80be70;">{{__('here')}}</a></p>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            {{__('Kind regards')}},<br>
            {{__('Your Buycycle team')}}
        </td>
    </tr>
@endsection
