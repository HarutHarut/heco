@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/cart.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="shipping-section d-flex">
        <div class="shipping-address">
            <div class="shipping-address-container">
                <div class="cart-2-head">
                    <img src="{{ $bike->image('side') ? $bike->image('side') : $bike->image_path ?? '/img/heco-1.png'}}" alt="{{ $bike->name ?? '' }}" width="280" height="266">
                    <div class="cart-2-head-block">
                        <h1>{{__('Bike')}}</h1>
                        <table class="shipping-table">
                            <tbody>
                            <tr>
                                <td>{{__('Specialized')}}</td>
                                <th>{{ $bike->name }} , {{ $bike->year }}</th>
                            </tr>
                            <tr>
                                <td>{{__('Size')}}</td>
                                <th>{{ $bike->frame_size }}</th>
                            </tr>
                            <tr>
                                <td>{{__('Condition')}}</td>
                                <th>{{__($bike->condition)}}</th>
                            </tr>
                            <tr>
                                <td>{{__('Milage')}}</td>
                                <th>{{ $bike->milage }}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($booking->is_shipping)
                    <h2>{{__('Shipping address')}}</h2>
                    <table class="shipping-table">
                        <tbody>
                        <tr>
                            <td>{{__('Name')}}</td>
                            <th>{{ $buyer->name }}</th>
                        </tr>
                        <tr>
                            <td>{{__('Address')}}</td>
                            <th>{{ $booking->street }}</th>
                        </tr>
                        <tr>
                            <td>{{__('House number')}}</td>
                            <th>{{ $booking->house_number }}</th>
                        </tr>
                        <tr>
                            <td>{{__('ZIP')}}</td>
                            <th>{{ $booking->zip }}</th>
                        </tr>
                        <tr>
                            <td>{{__('Phone')}}</td>
                            <th>{{ $booking->phone }}</th>
                        </tr>
                        <tr>
                            <td>{{__('City')}}</td>
                            <th>{{ $booking->city }}</th>
                        </tr>
                        </tbody>
                    </table>
                @endif

            </div>
        </div>

        <div class="shipping-total">
            <div class="shipping-total-container">
                <h2>{{__('Subtotal')}}</h2>

                <div class="cart-price-block cart-price">
                    <table>
                        <tbody>
                        <tr>
                            <td>{{__('Bike price')}}</td>
                            <td>
                                <span>{{ $price ? (app()->getLocale()=='de') ? number_format($price, 2,',','.').' €' : number_format($price, 2,'.',',').' €': null }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{__("Package")}} - {{__(ucfirst(config('enums.service_fee.' . $booking->package_id)['name']))}}</td>
                            <td><span>{{ $booking->service_fee ? (app()->getLocale()=='de') ? number_format($booking->service_fee, 2,',','.').' €' : number_format($booking->service_fee, 2,'.',',').' €': null }}</span></td>
                        </tr>
                        <tr>
                            <td>{{__('Stripe fee')}}</td>
                            <td><span>{{\App\Models\Booking::FEE_PERCENT}} %</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <p>
                        <b>{{__('Total price')}}</b>
                        <span><b>{{ $booking->price ? (app()->getLocale()=='de') ? number_format($booking->price, 2,',','.').' €' : number_format($booking->price, 2,'.',',').' €': null }}</b></span>
                    </p>

                    <form action="{{route('pay', $booking->id)}}" method="POST">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn_green">{{__('Pay')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

@endsection


