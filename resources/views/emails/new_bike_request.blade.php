@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            @if($type == 'rejected1' || $type == 'approved1')
            <b>{{__('Dear')}} <span>{{$data->user->first_name . ' ' . $data->user->last_name}}</span></b>
            @else
                <b>{{__('Dear')}} <span>{{$data->email}}</span></b>
            @endif
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            @if($type == 'rejected1')
                <p style="color: #ffffff">{{__('Your bike was declined by Buycycle back office')}}</p>
                <p style="color: #ffffff">{{__('Please try again')}}</p>

            @elseif($type == 'approved1')
                <p style="color: #ffffff">{{__('Your bike was accepted by Buycycle Back office')}}</p>

            @elseif($type == 'rejected2')
                <p style="color: #ffffff">{{__('Your request to add a new bike model was declined by Buycycle Back office')}}</p>
                <p style="color: #ffffff">{{__('Please try again')}}</p>

            @elseif($type == 'approved2')
                <p style="color: #ffffff">{{__('Your request to add a new bike model was accepted by Buycycle Back office')}}</p>
{{--                <p style="color: #ffffff">{{__('Please click')}} <a href="{{config('app.url')."/sell?brand_id=$bike->brand_id&model_id=$bike->brand_model_id"}}" style="color: #80be70;"> {{__('here')}} </a>{{__('to continue the sell process')}}</p>--}}
                <p style="color: #ffffff">{{__('Please click')}}

                    <a href="{{config('app.url')."/sell/select?search=&search_year=&year=&brand=$bike->brand_id&model=$bike->brand_model_id"}}" style="color: #80be70;"> {{__('here')}}
                    </a>{{__('to continue the sell process')}}
                </p>
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





