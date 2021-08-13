@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="sell-6">
        <div class="sell-6-container">
            <div class="sell-6-info">
                <h1>{{ $bike->model->name }}</h1>
                <h3>{{__('Private Party Range:')}} <span>{{ round($price_min) }} - {{ round($price_max)}}</span> €</h3>
                <h2>{{__('MRSP:')}} <span>{{ $old_bike->msrp }}</span> €</h2>
                <hr>

                <div class="sell-6-info_buttons">
                    <a href="#" data-hystmodal="#components" class="btn btn_white">{{__('View components')}}</a>
                    <a href="{{ route('shop.index',['model_ids' => "[{$bike->model->id}]" ?? [], 'brand_ids' => "[{$old_bike->brand_id}]" ?? [], 'year' => "[{$old_bike->year}]"] ) }}"
                       target="_blank"
                       class="btn btn_white">{{__('View offers for this bike')}}
                    </a>

                    <a href="#" data-hystmodal="#sale-work" class="btn btn_white">{{__('button pop up')}}</a>

                    @auth
                        <a href="{{ route('sell.images', $bike->id) }}"
                           class="btn btn_green w-100">{{__('Continue the process')}}</a>
                    @else
                        <button data-hystmodal="#login-modal" type="button"
                                class="btn btn_green w-100">{{__('log_in_and_continue_the')}}</button>
                    @endauth
                </div>

            </div>
            <div class="sell-6-img">
                <img src="{{ $old_bike->side_image ?? $old_bike->image_path ?? '/img/sellbike-1.jpg'  }}" alt="sellbike">
            </div>
        </div>

        <div class="hystmodal login-modal" id="components" aria-hidden="true">
            <div class="hystmodal__wrap">
                <div class="hystmodal__window" role="dialog" aria-modal="true">
                    <button data-hystclose class="hystmodal__close">Close</button>

                    <h2 class="font-light text-center modal-title">{{__('Details')}}</h2>
                    <table class="modal-details-table">
                        @foreach($old_bike->bike_settings as $item)
                            <tr>
                                <td>
                                    <span>{{ __($item->detail->key) }}</span>
                                </td>

                                <td>
                                    <span>{{ $item->value }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>

        <div class="hystmodal width-modal" id="sale-work" aria-hidden="true">
            <div class="hystmodal__wrap">
                <div class="hystmodal__window" role="dialog" aria-modal="true">
                    <button data-hystclose class="hystmodal__close">Close</button>

                    <h2 class="font-light text-center modal-title">{{__('How does the sale work?')}}</h2>
                    <p>{{__('At buycycle you can easily, safely and quickly put your bike up for sale')}}</p>
                    <p>{{__('In the next step, we ask you to take photos of your bike and then provide some information about its use')}}</p>
                    <p>{{__('Furthermore, we will upload all the standard components of your bike in the fields provided. If you have changed any of them, please click on the yellow circles to change them')}}</p>
                    <p>{{__('It is very important that you provide the information to the best of your knowledge and belief, because we at buycycle offer buyer protection')}} <br>
                        {{__('If someone buys your bike and it differs significantly from the information in your ad, we will step in. We get the bike sent to us by the buying party, assess whether there is a discrepancy and take care of the reversal of the sale or any necessary repairs')}}
                    </p>
                    <p>{{__('But dont worry: as long as you provide all the information carefully, you dont have to worry about potential returns')}}</p>
                    <p>{{__('We also handle payment completely through our payment service providers. This means that buyers pay for the bike online before you send it to them, or they can pick it up')}}</p>
                    <p>{{__('After the bike has been handed over to the buyer or the shipping company, you will receive your money directly into your bank account')}}</p>
                    <p>{{__('Have fun selling your bike!')}}</p>

                </div>
            </div>
        </div>
    </section>

@endsection


