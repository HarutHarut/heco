@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/cart.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="cart-section">
        <form style="display: none" id="pick_up_modal"
              action="{{ route('shipping.info.store', ['bike_id' => $bike->id]) }}"
              method="POST">
            @csrf
            <input type="hidden" name="package_id" value="{{$package_id}}">
        </form>

        <div class="cart-container">

            <img src="{{ $bike->image('side') ? $bike->image('side') : $bike->image_path ?? '/img/heco-3.jpg' }}" alt=""
                 width="280" height="266">

            <div class="cart-block">
                <h1>{{__('Shopping Basket')}}</h1>
                <table>
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
                    <tr>
                        <td>{{__('Qty')}}</td>
                        <th>1</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="padding-top: 30px;"></th>
                    </tr>
                    <tr class="price-tr">
                        <td>{{__('Bike price')}}</td>
                        <th>
                            <div class="cart-block-price">
                                <p>
                                    <span>{{ $price ? (app()->getLocale()=='de') ? number_format($price, 2,',','.').' €' : number_format($price, 2,'.',',').' €': null }}</span>
                                </p>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-bottom: 30px;"></td>
                    </tr>

                    <tr>
                        <th colspan="2" style="font-size: 16px; padding-bottom: 10px">{{__('Additonal cost')}}</th>
                    </tr>
                    <tr>
                        <td>{{__("Package")}} - {{__(ucfirst(config('enums.service_fee.' . $package_id)['name']))}}</td>
                        <th>
                            <span>{{ config('enums.service_fee.'.$package_id)['price'] ? (app()->getLocale()=='de') ? number_format(config('enums.service_fee.'.$package_id)['price'], 2,',','.').' €' : number_format(config('enums.service_fee.'.$package_id)['price'], 2,'.',',').' €': null }} </span>
                        </th>
                    </tr>
                    <tr>
                        <td>{{__('Stripe fee')}}</td>
                        <th><span>{{\App\Models\Booking::FEE_PERCENT}}</span> %</th>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="cart-price">
                <h2>{{__('Subtotal')}}</h2>
                <div class="cart-price-block">
                    <table>
                        <tbody>
                        <tr>
                            <td>{{__('Bike price')}} <b class="drag-tooltip">{{__('Bike price tooltip')}}</b></td>
                            <td>
                                <span>{{ $price ? (app()->getLocale()=='de') ? number_format($price, 2,',','.').' €' : number_format($price, 2,'.',',').' €': null }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{__("Package")}} - {{__(ucfirst(config('enums.service_fee.' . $package_id)['name']))}} <b class="drag-tooltip">{{__(ucfirst(config('enums.service_fee.' . $package_id)['name']) . ' service fee tooltip')}}</b></td>
                            <td>
                                <span>{{ config('enums.service_fee.'.$package_id)['price'] ? (app()->getLocale()=='de') ? number_format(config('enums.service_fee.'.$package_id)['price'], 2,',','.').' €' : number_format(config('enums.service_fee.'.$package_id)['price'], 2,'.',',').' €': null }}</span>
                            </td>
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
                        <span><b>{{ $total ? (app()->getLocale()=='de') ? number_format($total, 2,',','.').' €' : number_format($total, 2,'.',',').' €': null }} </b></span>
                    </p>


                    <div class="text-center">

                        @auth
                           @if($package_id == 0)
                                <button type="button" id="pick_up" class="btn btn_green">{{__('Checkout')}}</button>
                           @else
                                <a href="{{route('shipping.address', ['bike_id' => $bike->id, 'package_id'=>$package_id ])}}"
                                   class="btn btn_green">{{__('Checkout')}}
                                </a>
                            @endif
                        @else
                            <button type="button"
                                    class="btn btn_green"
                                    data-hystmodal="#login-modal">
                                {{__('log in and checkout')}}
                            </button>
                        @endauth

                    </div>


                </div>
            </div>
        </div>
    </section>


    <section class="shop-single-3">
        <h2>{{__('Similar Models')}}</h2>
        @if(count($similar_models))
            <div class="shop-item-container similar-slider">
                @foreach($similar_models as $item)
                    <div class="shop-item">
                        <a href="{{ route('shop.bike', $item->slug) }}" class="shop-item-img-block">
                            <img
                                src="{{ $item->image('side') ? $item->image('side') : $item->image_path ?? '/img/heco-1.png'}}"
                                alt="{{__('Diverge E5 Base')}}"
                                width="352" height="222"
                                loading="lazy">
                            @if($item->check_time && !$item->is_sold)
                                <span class="bike-new"> {{__('Availabe From'). ' '.$item->check_time}}</span>
                            @endif
                            @if($item->IsNew && ! $item->check_time)
                                <span class="bike-new"> {{__('New')}}</span>
                            @endif
                            @if($item->is_sold)
                                <span class="bike-new"> {{__('Sold')}}</span>
                            @endif
                            @if(Auth::check())
                                <span data-bike_id="{{ $item->id }}"
                                      class="heart-icon @if(Auth::user()->favorite->contains($item)) active @endif"
                                      title="Favorites"></span>
                            @endif

                        </a>
                        <div class="shop-item-info-block">

                            <div class="shop-item-title">
                                <h2 title="{{__('Diverge E5 Base')}}">{{ $item->brand->name ?? '' }}
                                    , {{ $item->name }}</h2>
                                <div class="form-group checkbox-choose ml-auto" title="{{__('compare')}}">
                                    <input onchange="compare( {{$item->id}})" type="checkbox" id="choose{{$item->id}}"
                                           class="form-check-input">
                                    <label for="choose{{$item->id}}" class="form-check-label">
                                        <span>
                                            <img src="/img/scale.svg" alt="compare" width="21" height="20"
                                                 loading="lazy">
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <table>
                                <tr>
                                    <td>{{__('Specialized')}}</td>
                                    <td>{{ $item->year }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Size')}}</td>
                                    <td>{{ $item->frame_size }}</td>
                                </tr>
                            </table>

                            <div class="shop-item-price-block">
                                <div class="shop-item-price">
                                    <p><span>{{ $item->format_price }}</span> €</p>
                                </div>
                                @if(!$item->check_time && !$item->is_sold)
                                    <a href="{{ route('shop.bike', $item->slug) }}"
                                       class="btn btn_green">{{__('Buy Now')}}</a>
                                @else
                                    <a href="{{ route('shop.bike', $item->slug) }}"
                                       class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3>{{__('Currently no similar models are published')}}</h3>
        @endif
    </section>
    @if(count($veviewed_bikes))
        <section class="shop-single-3">
            <h2>{{__('The bicycle that you veviewed')}}</h2>
            <div class="shop-item-container">
                @foreach($veviewed_bikes as $item)
                    <div class="shop-item">

                        <a href="{{ route('shop.bike', $item->bike->slug) }}" class="shop-item-img-block">
                            <img
                                src="{{ $item->bike->image('side') ? $item->bike->image('side') : $item->bike->image_path ?? '/img/heco-1.png'}}"
                                alt="{{ $item->bike->name ?? '' }}" width="352"
                                height="222"
                                loading="lazy">
                            @if($item->bike->check_time  && !$item->bike->is_sold)
                                <span class="bike-new"> {{__('Availabe From'). ' '.$item->bike->check_time}}</span>
                            @endif
                            @if($item->bike->IsNew && ! $item->bike->check_time)
                                <span class="bike-new"> {{__('New')}}</span>
                            @endif
                            @if($item->bike->is_sold)
                                <span class="bike-new"> {{__('Sold')}}</span>
                            @endif
                            @if(Auth::check())
                                <span data-bike_id="{{ $item->bike_id }}"
                                      class="heart-icon @if(Auth::user()->favorite->contains($item->bike_id)) active @endif"
                                      title="Favorites"></span>
                            @endif
                        </a>

                        <div class="shop-item-info-block">

                            <div class="shop-item-title">
                                <h2 title="{{ $item->bike->name ?? '' }}">{{ $item->bike->brand->name ?? '' }}
                                    , {{ $item->bike->name ?? '' }}</h2>
                                <div class="form-group checkbox-choose ml-auto" title="{{__('compare')}}">
                                    <input onchange="compare( {{$item->bike_id}})" type="checkbox"
                                           id="choose_v_{{$item->bike_id}}" class="form-check-input">
                                    <label for="choose_v_{{$item->bike_id}}" class="form-check-label">
                                        <span><img src="/img/scale.svg" alt="compare" width="21" height="20"
                                                   loading="lazy"></span>
                                    </label>
                                </div>
                            </div>

                            <table>
                                <tr>
                                    <td>{{__('Specialized')}}</td>
                                    <td>{{ $item->bike->year }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Size')}}</td>
                                    <td>{{ $item->bike->frame_size }}</td>
                                </tr>
                            </table>

                            <div class="shop-item-price-block">
                                <div class="shop-item-price">
                                    <p><span>{{ $item->bike->format_price }}</span> €</p>
                                </div>
                                @if(!$item->bike->check_time && !$item->bike->is_sold)
                                    <a href="{{ route('shop.bike', $item->bike->slug) }}"
                                       class="btn btn_green">{{__('Buy Now')}}</a>
                                @else
                                    <a href="{{ route('shop.bike', $item->bike->slug) }}"
                                       class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection



@section('scripts')
    <script src="/js/lightslider-light-gallery.js"></script>
    <script>
        $('#pick_up').on('click', function (e) {
            e.preventDefault();
            $('#pick_up_modal').submit();
        });

        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'City'
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#imageGallery').lightSlider({
                item: 1,
                slideMargin: 23,
                pager: false,
                controls: true,
                autoWidth: true,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            autoWidth: false,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            autoWidth: true,
                        }
                    }
                    ,
                    {
                        breakpoint: 500,
                        settings: {
                            autoWidth: false,
                        }
                    }
                ],
            });


            var lightSlider = $('.similar-slider').lightSlider({
                item: 3,
                slideMargin: 0,
                pager: false,
                controls: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            item: 1,
                        }
                    }
                ],
            });

            if ($(window).width() <= 767) {
                lightSlider.destroy()
            }
        });

    </script>
@endsection
