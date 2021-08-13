@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{$name}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            @if($type == 'Counter offer')
                <p>{{__('You have just received a price quote')}}</p>
                <p>{{__('for your bike. You can take a look at it')}}</p>
                <p>{{ __('here:')}}
                    <a href="{{route('notifications')}}" style="color: #80be70;">{{ config('app.url') . '/notifications' }}</a>
                </p>

            @elseif($type == 'rejected-seller')
                <p>{{__('Unfortunately, the seller has rejected your price offer')}}</p>
                <p>{{__('Look for a compromise and make a new offer')}}</p>

            @elseif($type == 'rejected-buyer')
                <p>{{__('Unfortunately, your counteroffer was rejected by the buyer')}}</p>
                <p>{{__('Try to meet him half way and make a new offer')}}</p>

            @elseif($type == 'approved')
                <p>{{__('Good negotiation! Your price offer has been accepted by the seller')}}</p>
                <p>{{__('Click on the link to complete your purchase')}}</p>
                <a href="{{route('notifications')}}" style="color: #80be70;">{{ config('app.url') . '/notifications' }}</a>

            @elseif($type == 'new-request')
                <p>{{__('You have received a counter offer')}}</p>
                <p>{{__('from the seller You can view it here')}}</p>
                <p>{{ __('here:')}}
                    <a href="{{route('notifications')}}" style="color: #80be70;">{{ config('app.url') . '/notifications' }}</a>
                </p>

            @elseif($type == 'Timelimit is exceeded')
                <p>{{__('Unfortunately, there is no response to your price offer.')}}</p>
                <p>{{__('Therefore, in order for the trade on buycycle to work smoothly, we have rejected the offer')}}</p>
                <p>{{__('Have another look at the bike:')}}</p>

            @endif
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <p>{{__('Best regards, your buycycle Team!')}}</p>
        </td>
    </tr>
@endsection



