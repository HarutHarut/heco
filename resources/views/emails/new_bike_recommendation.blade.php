@extends('emails.layouts.app')
@section('content')
    <tr>
        <td style="color: #ffffff; font-size: 20px; padding-bottom: 20px;">
            <b>{{__('Hi')}} <span>{{__('Admin')}}</span></b>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; font-size: 16px; padding-bottom: 20px;">
            <p><b>{{__('Brand')}}: {{$data['brand_recomm']}}</b></p>
            <p><b>{{__('Model')}}: {{$data['model_recomm']}}</b></p>
            <p><b>{{__('Year')}}: {{$data['year_recomm']}}</b></p>
            <p><b>{{__('Email')}}: {{$data['email_recomm']}}</b></p>
            <p>{{__('For approving or declining please enter')}} <a href="{{ config('app.url') . '/dashboard/newbike' }}" style="color: #80be70;">{{__('here')}}</a></p>
        </td>
    </tr>
@endsection




