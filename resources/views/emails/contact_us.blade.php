@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{__('Admin')}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <p><b>{{__('Name')}}:</b> {{$data['name']}}</p>
            <p><b>{{__('Email')}}:</b> {{$data['email']}}</p>
            <p><b>{{__('Message')}}:</b> {{$data['message']}}</p>
        </td>
    </tr>
@endsection
