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
                @if(!$booking->is_shipping)
                    <p>{{__('Thank you for confirming the sale')}}</p>
                    <p>{{__('We have sent your contact details to the happy new owner of your bike')}}</p>
                    <p>{{__('To ensure a smooth handover of the bike, you can also find the buyers contact details again here')}}</p>
                    <p><b>{{__('Phone')}}:</b> {{$booking->user->phone}}</p>
                    <p><b>{{__('Email')}}:</b> {{$booking->user->email}}</p>
                    <p>{{__('Please send us a short mail after successful delivery, so that we can pay you the money')}}</p>
                    <a href="{{route('booking.actions', ['token' => $booking->action_token, 'type' => 'seller', 'accept' => 1])}}" style="color: #80be70;">{{route('booking.actions', ['token' => $booking->action_token, 'type' => 'seller', 'accept' => 1])}}</a>
                @else
                <p>{{__('Congratulations on the sale of your bike')}}</p>
                <p>{{__('We hope the parting ways isn ́t too hard for you')}}</p>
                <p>{{__('Here you can find again the details about your sale')}}</p>
                <p><b>{{__('Bike')}}:</b> {{$booking->bike->name}}</p>
                <p>{{__('Next, we will send you packing materials to the address you provided')}}</p>
                <p>{{__('Please pack the bike properly')}}</p>
                <p>{{__('Once you have made the appointment with the shipping company, you will get your money and you can relax')}}</p>
                <p>{{__('We try to improve our service continuously')}}</p>
                <p>{{__('Therefore, we would appreciate if you could send us feedback on your selling experience by email to')}} <a href="mailto:info@buycycle.de" style="color: #80be70;">info@buycycle.de</a></p>
                @endif
            @else
                <p>{{__('Congratulations on your new dream bike!')}}</p>
                @if(!$booking->is_shipping)
                    <p>{{__('The seller has confirmed the sale.')}}</p>
                    <p>{{__('You have chosen to pick up your bike')}}</p>
                    <p>{{__('Therefore, below you will find the sellers contact information')}}</p>
                    <p><b>{{__('Phone')}}:</b> {{$booking->bike->user->phone}}</p>
                    <p><b>{{__('Email')}}:</b> {{$booking->bike->user->email}}</p>
                    <p><b>{{__('ZIP')}}:</b> {{$booking->bike->user->zip}}</p>
                    <p><b>{{__('Address')}}:</b> {{$booking->bike->user->city . ', ' . $booking->bike->user->street . ', ' . $booking->bike->user->house_number}}</p>
                    <p>{{__('Arrange a pickup date together')}}</p>
                    <p>{{__('Please confirm a smooth delivery by email, so we can pay the money to the seller')}}</p>
                    <a href="{{route('booking.actions', ['token' => $booking->action_token, 'type' => 'buyer'])}}" style="color: #80be70;">{{route('booking.actions', ['token' => $booking->action_token, 'type' => 'buyer'])}}</a>
                    <p>{{__('Thank you and have fun with your new bike')}}</p>
                @else
                    <p>{{__('The seller has confirmed the sale')}}</p>
                @endif
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







