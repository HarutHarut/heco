@extends('layouts.app')

@section('PageCss')
    <link href="/css/select2.css" rel="stylesheet">
    <link href="{{mix('/css/cart.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="shipping-section d-flex">

        <div class="shipping-address">
            <div class="shipping-address-container">
                <h1>{{__('Shipping address')}}</h1>

                <form id="address_form" action="{{ route('shipping.info.store', [ 'bike_id' => $bike->id ]) }}"
                      method="POST">
                    @csrf
                    <input id="shipping_met" type="hidden" name="package_id" value="{{$package_id}}">

                    <div class="form-group">
                        <input type="text" placeholder="{{__('First Name')}}" name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name', Auth::user()->first_name) }}" aria-label="{{__('FirstName')}}">
                        @error('first_name')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="{{__('Last Name')}}" name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', Auth::user()->last_name) }}" aria-label="{{__('LastName')}}">
                        @error('last_name')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="tel" placeholder="{{__('Phone')}}" name="phone"
                               class="form-control @error('phone') is-invalid @enderror tel-input"
                               value="{{ old('phone', Auth::user()->phone) }}" aria-label="{{__('Phone')}}">
                        @error('phone')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="{{__('City')}}" id="search-address" name="city"
                               class="form-control @error('city') is-invalid @enderror" aria-label="{{__('City')}}"
                               value="{{ old('city', Auth::user()->city) }}">
                        @error('city')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="{{__('Street')}}" name="street"
                               class="form-control @error('street') is-invalid @enderror"
                               value="{{ old('street', Auth::user()->street) }}" aria-label="{{__('Street')}}">
                        @error('street')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="{{__('House number')}}" name="house_number"
                               value="{{ old('house_number', Auth::user()->house_number) }}"
                               class="form-control @error('house_number') is-invalid @enderror"
                               aria-label="{{__('House number')}}">
                        @error('house_number')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="{{__('ZIP')}}" name="zip" value="{{ old('zip', Auth::user()->zip) }}"
                               class="form-control @error('zip') is-invalid @enderror" aria-label="{{__('ZIP')}}">
                        @error('zip')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex">
                        <div class="form-group custom-checkbox">
                            <input name="save_information" type="checkbox" class="form-check-input" id="save-info">
                            <label class="form-check-label" for="save-info">{{__('Save information for next time')}}</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="shipping-total">
            <div class="shipping-total-container">
                <h2>{{__('Subtotal')}}</h2>

                <div class="cart-price-block cart-price">
                    <table>
                        <tbody>
                        <tr>
                            <td>{{__('Bike price')}} <b class="drag-tooltip">{{__('Bike price tooltip')}}</b></td>
                            <td>
                                <span>{{ $price ? (app()->getLocale()=='de') ? number_format($price, 2,',','.').' €' : number_format($price, 2,'.',',').' €': null }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{__("Package")}} - {{__(ucfirst(config('enums.service_fee.' . $package_id)['name']))}} <b class="drag-tooltip">{{__(ucfirst(config('enums.service_fee.' . $package_id)['name']))}} {{__('Service fee tooltip')}}</b></td>
                            <td><span>{{  config('enums.service_fee.'.$package_id)['price'] ? (app()->getLocale()=='de') ? number_format( config('enums.service_fee.'.$package_id)['price'], 2,',','.').' €' : number_format( config('enums.service_fee.'.$package_id)['price'], 2,'.',',').' €': null }} </span></td>
                        </tr>
                        <tr>
                            <td>{{__('Stripe fee')}} <b class="drag-tooltip">{{__('Stripe fee tooltip')}}</b></td>
                            <td><span>{{\App\Models\Booking::FEE_PERCENT}} %</span></td>
                        </tr>

                        </tbody>
                    </table>
                    <hr>
                    <p>
                        <b>{{__('Total price')}}</b>
                        <span><b>{{ $total ? (app()->getLocale()=='de') ? number_format($total, 2,',','.').' €' : number_format($total, 2,'.',',').' €': null }}</b></span>
                    </p>

                    <div class="text-center">
                        <button type="button" class="btn btn_green" id="delivery_submit">
                            {{__('Checkout')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('scripts')
    <script src="/js/Select2.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&libraries=places"></script>

    <script>
        function initialize() {
            var ac = new google.maps.places.Autocomplete(document.getElementById('search-address'));
            ac.setComponentRestrictions(
                {'country': ['DE'], 'postalCode': []});
        }

        $(function () {
            initialize();
        });

        $('#delivery_submit').on('click', function (e) {
            e.preventDefault();
            $('[name="phone"]').val(iti.getNumber())
            // $('#shipping_met').val('delivery');
            $('#address_form').submit();
        });
    </script>

@endsection
