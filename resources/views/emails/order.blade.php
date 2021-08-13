@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            @if($type == 'seller')
                <b>{{__('Hi')}} <span>{{$data->bike->user->first_name}}</span></b>
            @else
                <b>{{__('Hi')}} <span>{{$data->user->first_name}}</span></b>
            @endif
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            @if($type == 'seller')
                <p>{{__('Congratulations, a new owner for your bike has been found!')}}</p>
                <p>{{__('We ask you to confirm the sale within the next 24 hours')}}</p>
                <p>{{__('Please follow the link below')}}</p>
                <a href="{{route('booking.actions', ['token' => $data->action_token, 'type' => 'seller'])}}" style="color: #80be70;">{{route('booking.actions', ['token' => $data->action_token, 'type' => 'seller'])}}</a>
            @else
                <p>{{__('To make sure that the seller can deliver the offered bike properly, he now has 24 hours to confirm the purchase')}}</p>
                <p>{{__('We know that 24 hours is quite a long time to wait for your dream bike')}}</p>
                <p>{{__('However, we do not want to create unnecessary disappointment if the buyer does not want to sell his bike after all')}}</p>
            @endif
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            {{__('Kind regards')}},<br>
            {{__('Your Buycycle team')}}
        </td>
    </tr>
@endsection



