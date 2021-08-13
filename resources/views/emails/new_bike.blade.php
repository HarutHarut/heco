@extends('emails.layouts.app')
@section('content')

    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>@if($type){{$user['name']}}@else{{__('Admin')}} @endif</span></b>
        </td>
    </tr>

    <tr>

        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            @if($type)
                <p>{{__('We are glad that you want to sell your bike on buycycle')}}</p>
                <p>{{__('To ensure the quality of the offers')}}</p>
                <p>{{__('we will check your ad and get back to you within the next 24 hours')}}</p>
            @else
                <p>{{__('Seller Name:').' '. $user['name'] }}</p>
                <p>{{__('Bike Brand:').' '.  $bike->brand->name }}</p>
                <p>{{ __('Bike Model:').' '. $bike->model->name }}</p>
                <p>{{__('For approving or declining please enter')}} <a
                        href="{{ config('app.url') . '/dashboard/notifications' }}" style="color: #80be70;">{{__('here')}}</a></p>
            @endif
        </td>

    </tr>



@endsection
