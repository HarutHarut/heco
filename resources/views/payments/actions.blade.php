@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="sell-1-container">
        <h1>{{ __('Accept - Decline Booking') }}</h1>
    </div>
    <form action="{{ route('booking.actions.store', $booking->id) }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{$type .'_confirm'}}">
        <input type="hidden" name="accept" value="{{request()->get('accept')}}">
        <section class="sell-1">
            <div class="sell-1-container">
                @if($booking->is_shipping && $type == 'seller')
                <p>{{__('Please fill in the pickup date for delivery process')}}</p>
                @endif
                <div class="sell-1-form">
                    @if($booking->is_shipping && $type == 'seller')
                    <div class="form-group">
                        <input
                            type="date"
                            name="pickup_date"
                            class="form-control"
                            aria-label="{{__('Pickup date')}}"
                            value="{{now()->addDay()->format('Y-m-d')}}">
                    </div>
                        @endif
                            <button type="submit" class="btn btn_green">{{__('Confirm')}}</button>
                            <a href="#" id="decline" class="btn btn_grey">{{__('Decline')}}</a>
                </div>
            </div>

    </section>
    </form>
    <form action="{{ route('booking.actions.decline', $booking->id) }}" method="POST" id="decline_form">
        @csrf
        <input type="hidden" name="type" value="{{$type .'_decline'}}">
    </form>

@endsection
@section('scripts')
    <script>
        $('#decline').click(function (){
            $('#decline_form').submit();
        })
    </script>
@endsection
