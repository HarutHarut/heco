@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{__('Admin')}}</span></b>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <p><b>{{$data['name']}}</b> {{__(' user wants to take advice about')}} <a href="{{$data['url']}}"
                                                                                      target="_blank">{{__('this')}}</a> {{__('model.')}}
            </p>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <p><b>{{__('Contact information')}}</b><br>
            @if($data['email'])
                <p><b>{{__('Email')}}:</b> {{$data['email']}}</p>
            @endif
            @if($data['phone'])
                <p><b>{{__('Phone')}}:</b> {{$data['phone']}}</p>
            @endif
        </td>
    </tr>
@endsection

