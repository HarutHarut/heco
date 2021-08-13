@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{__('Admin')}}</span></b>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <h4>{{__('Booking Information')}}</h4>
            <p><b>{{__('Price')}}:</b> {{$booking->format_price}}</p>
            <p><b>{{__('Type')}}:</b> {{(!$booking->is_shipping) ? 'PickUp' : 'Delivery'}}</p>
            @if($booking->package_id == 2)
                <p><b>{{__('Packagetype')}}:</b> {{__(ucfirst(config("enums.service_fee.$booking->package_id")['name']) . ' package')}}</p>
            @endif
            <br>
            <h4>{{__('Buyer Information')}}</h4>
            <p><b>{{__('Name')}}:</b> {{$booking->user->name}}</p>
            <p><b>{{__('City')}}:</b> {{$booking->city}}</p>
            <p><b>{{__('Street')}}:</b> {{$booking->street}}</p>
            <p><b>{{__('House number')}}:</b> {{$booking->house_number}}</p>
            <p><b>{{__('ZIP')}}:</b> {{$booking->zip}}</p>
            <p><b>{{__('Phone')}}:</b> {{$booking->phone}}</p>
            <br>
            <h4>{{__('Owner Information')}}</h4>
            <p><b>{{__('Name')}}:</b> {{$booking->bike->user->name}}</p>
            <p><b>{{__('City')}}:</b> {{$booking->bike->user->city}}</p>
            <p><b>{{__('Street')}}:</b> {{$booking->bike->user->street}}</p>
            <p><b>{{__('House number')}}:</b> {{$booking->bike->user->house_number}}</p>
            <p><b>{{__('ZIP')}}:</b> {{$booking->bike->user->zip}}</p>
            <p><b>{{__('Phone')}}:</b> {{$booking->bike->user->phone}}</p>
            <br>
            <h4>{{__('Bike Information')}}</h4>
            <a href="{{route('shop.bike', $booking->bike->slug)}}" style="color: #80be70;">{{$booking->bike->name}}</a>
        </td>
    </tr>
@endsection



