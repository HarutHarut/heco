@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{$bike->user->name}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <h4>{{__('You have new comment for your bike')}}</h4>
            <p>{{__('Please check your profile')}}</p>
            <p>{{__('to see comments please click')}} <a href="{{ config('app.url') . '/bike/' . $bike->slug }}" style="color: #80be70;">{{__('here')}}</a></p>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            {{__('Kind regards')}},<br>
            {{__('Your Buycycle team')}}
        </td>
    </tr>
@endsection
