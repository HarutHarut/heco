@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            @if($type == 'seller')
                <b>{{__('Hi')}} <span>{{$booking->bike->user->first_name}}</span></b>
            @else
                <b>{{__('Hi')}} <span>{{$booking->user->first_name}}</span></b>
            @endif
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            @if($type == 'seller')
                <p>{{__('Since you have declined the offer to sell your bike, we assume that you have sold your bike elsewhere')}}</p>
                <p>{{__('Therefore we deactivate your sale ad')}}</p>
                <p>{{__('If this was an oversight, please send us an email to')}} <a href="mailto:info@buycycle.de" style="color: #80be70;">info@buycycle.de</a></p>
            @else
                <p>{{__('Unfortunately, the seller has rejected your offer to buy')}}</p>
                <p>{{__('It may be that the seller has sold the bike on another platform or does not want to sell it after all')}}</p>
                <p>{{__('Please excuse the inconvenience')}}</p>
                <p>{{__('We are constantly working to have only active sellers on our platform')}}</p>
                <p>{{__('There is a right gear for every mountain')}}</p>
                <p>{{__('We are sure that you will still find your dream bike on buycycle.')}}</p>
                <p>{{__('To shorten the time until then, you will receive a separate email from us with a Komoot voucher code')}}</p>
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
