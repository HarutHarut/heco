@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/shop-single.css')}}" rel="stylesheet">
@endsection

@section('content')

    @include('flash::message')

    <section class="shop-single-1">

        <div class="shop-single-1-left">
            <div class="shop-single-user">
                <figure>
                    <img
                        src="{{  isset($bike->user->image_path) ? $bike->user->imagePath : '/img/user.svg' }}"
                        alt="user_image">
                    <figcaption>
                        <h3>{{$bike->user->name ?? ''}}</h3>
                    </figcaption>
                </figure>
                @if(Auth::check())
                    <span data-bike_id="{{ $bike->id }}"
                          class="heart-icon @if(Auth::user()->favorite->contains($bike)) active @endif"
                          title="Favorites"></span>
                @else
                    <span data-bike_id="{{ $bike->id }}"
                          class="heart-icon"
                          data-hystmodal="#login-modal"
                          title="Favorites"></span>
                @endif

            </div>

            <h1>{{ $bike->brand->name ?? '' }}, {{ $bike->name }}</h1>

            <table class="shop-single-1-table">
                <tr>
                    <td>{{__('Specialized')}}</td>
                    <th>{{ $bike->brand->name ?? ''}}, {{ $bike->name }}, <span>{{ $bike->year }}</span></th>
                </tr>
                <tr>
                    <td>{{__('Size')}} <span class="form-tooltip">
                            <a href="#" data-hystmodal="#size-modal2"><img src="/img/iconsQ2.png" alt=""
                                                                           width="17" height="17"></a>
                        </span></td>
                    <th>{{ $bike->frame_size }}</th>
                </tr>
                <tr>
                    <td>{{__('Condition')}} <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal2"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span></td>
                    <th>{{ __($bike->condition) }}</th>
                </tr>
                <tr>
                    <td>{{__('Milage')}}</td>
                    <th>{{ __($bike->milage)}}</th>
                </tr>
                <tr>
                    <td>{{__('Color')}}</td>
                    <th>
                        <div
                            style="background-color: {{ $bike->color ?? ''}};
                                width: 18px;
                                height: 18px;
                                border-radius: 50%;
                                ">
                        </div>
                    </th>
                </tr>
                <tr>
                    <td>{{__('Last Service')}}</td>
                    <th>{{ __($bike->last_service)}}</th>
                </tr>
                <tr>
                    <td>{{__('Was this bike preowned')}}</td>
                    @if($bike->preowned == 1)
                        <th>{{__('Yes')}}</th>
                    @else
                        <th>{{__('No')}}</th>
                    @endif
                </tr>
                <tr>
                    <td>{{__('Location')}}</td>
                    <th>{{ $bike->city}}</th>
                </tr>

                @if($bike->info)
                    <td>{{__('Info about bike')}}</td>
                    <th class="spoiler">
                        <p class="hidden-text" style="overflow: hidden; margin-bottom: 0">
                            {{ $bike->info}}
                        </p>
                    </th>
                @endif

                <tr>
                    <th colspan="2" style="padding-top: 30px"></th>
                </tr>
                <tr>
                    <td colspan="2" style="padding-right: 0">
                        <div class="shop-single-1-table-buttons-container">
                            <div class="shop-single-1-table-buttons">
                                <button type="button" class="btn-link" data-hystmodal="#secure-payment">
                                    <img src="/img/secure-payment.svg" alt="">
                                    <span>{{__('100% Secure Payment')}}</span>
                                </button>
                                <button type="button" class="btn-link" data-hystmodal="#buy-without-risk">
                                    <img src="/img/buy-without.svg" alt="">
                                    <span>{{__('Buy without Risk')}}</span>
                                </button>
                            </div>

                            <div class="shop-single-1-table-buttons">
                                <button type="button" class="btn-link" data-hystmodal="#insured-shipping">
                                    <img src="/img/insured.svg" alt="">
                                    <span> {{__('Insured Shipping')}}</span>
                                </button>
                                <button type="button" class="btn-link" data-hystmodal="#premium-check">
                                    <img src="/img/premium-badge.svg" alt="">
                                    <span>{{__('Premium Check')}}</span>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" style="padding-top: 30px"></th>
                </tr>

                <tr class="price-tr">
                    <td>{{__('Price')}}</td>
                    <th>
                        <div class="shop-single-price">
                            <p>
                                <span>{{ $price ? (app()->getLocale()=='de') ? number_format($price, 2,',','.') : number_format($price, 2,'.',','): null }} {{ $bike->msrp_currency }}</span>
                            </p>
                            <div class="mrsp-price">
                                <i>{{__('new price MRSP')}}</i>
                                <b>{{__('MRSP:').' '.$bike->msrp ? (app()->getLocale()=='de') ? number_format($bike->msrp, 2,',','.') : number_format($bike->msrp, 2,'.',','): null }}
                                    <span>{{ $bike->msrp_currency }}</span></b></div>

                        </div>
                    </th>
                </tr>
            </table>
            @if($bike->shipping == 1)
                <p><b>{{__('Lieferoption')}}</b></p>
                <p>{{__('Selbstabholung und Lieferung kann beim nächsten Schritt ausgewählt werden')}}</p>
            @endif

            @if($bike->user_id != Auth::id())
                @if(!$bike->is_sold)
                    <div class="shop-single-buttons">
                        @if(!$bike->check_time)
                            @if($bike->bargain == 1 && Auth::check() && auth()->user()->email_verified_at)
                                <a href="#" class="btn btn_grey_light mr-7"
                                   data-hystmodal="#make-a-counter">{{__('Make a counter offer')}}</a>
                            @endif
                            @auth
                                    <a href="#" class="btn btn_green mr-7" data-hystmodal="#price-modal">{{__('Buy Now')}}</a>
                            @else
                                <a href="#"
                                   data-hystmodal="#login-modal"
                                   class="btn btn_green mr-7">{{__('Buy Now')}}</a>
                            @endauth
                                <a href="#" class="btn shop-btn-1" data-hystmodal="#deliver-option">{{__('Purchase advice')}}</a>
                        @else
                            <div class="availabe">
                                {{__('Availabe From'). ' '.$bike->check_time}}
                            </div>
                        @endif

                    </div>
                @else
                    <h2 style="color: red"><b>{{__('Sold out')}}</b></h2>
                @endif
            @endif
        </div>

        <div class="shop-single-1-right">
            <ul id="imageGallery" class="shop-single-slider">
                @foreach($bike->images as $item)
                    <li data-src="/storage/bikes/{{$item->imageable_id}}/{{ $item->path }}">
                        <img src="/storage/bikes/{{$item->imageable_id}}/{{ $item->path }}" alt="{{ $item->path }}"
                             width="436" height="737"/>
                    </li>
                @endforeach
            </ul>
        </div>

    </section>

    <section class="shop-single-2">
        <div class="tabs">
            <ul id="tabs-nav">
                <li><a href="#tab1">{{__('Detalis')}}</a></li>
                <li>/</li>
                <li><a href="#tab2">{{__('Shipping')}}</a></li>
                <li>/</li>
                <li><a href="#tab3">{{__('Warranty')}}</a></li>
            </ul>

            <div id="tabs-content">
                <div id="tab1" class="tab-content tab-details">
                    <h2>{{__('Components')}}</h2>
                    <table class="tab-table">
                        @foreach($details as $item)
                            @php
                                $detail_status = 0;
                                $detail_id = 0;
                                if (in_array($item->id, $bike->bike_settings->pluck('detail_id')->toArray())){
                                $detail_id = $item->id;
                                }

                                if ($detail_id){
                                $detail_status = $bike->bike_settings()->where('detail_id', $detail_id)->first()->status;
                                }
                                $value = '';
                                $detail = $bike->bike_settings()->where('detail_id', $item->id)->first();
                                    if ($detail){
                                        if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                            $value = $detail->note;
                                        }else{
                                            $value = $detail->value;
                                        }
                                    }
                            @endphp
                            <tr>
                                <td>{{__($item->key)}}</td>
                                @if($detail_status == 0)
                                    <td>
                                        <span>{{ $value ?? '-' }}</span>
                                    </td>
                                @elseif($detail_status == 1)
                                    <td>
                                        <span class="green-td">{{ $value ?? '-' }}</span>
                                    </td>
                                @elseif($detail_status == 2)
                                    <td>
                                        <span class="yellow-td">{{ $value ?? '-' }}</span>
                                    </td>
                                @elseif($detail_status == 3)
                                    <td>
                                        <span class="red-td">{{ $value ?? '-' }}</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>

                    <div class="component-info">
                        <div><span class="circle circle-green"></span> {{__('Replaced parts')}}</div>
                        <div><span class="circle circle-yellow"></span> {{__('Changed parts')}}</div>
                        <div><span class="circle circle-red"></span> {{__('Broken parts')}}</div>
                    </div>
                </div>
                <div id="tab2" class="tab-content">
                    <h2>{{__('Shipping Details')}}</h2>
                    <p>{{__('Through our standardized posts, you can see all the information you need to make an informed purchase decision, and you can pay for the bikes directly online')}}</p>
                    <p>{{__('Pickup: You pay for the bike and get the contact information of the seller')}}<br>
                        {{__('If you are not satisfied on the spot, you dont have to take it home and of course you will get your money back')}}
                    </p>
                    <p>{{__('Shipping: You pay for the bike and the seller gets packing material from us and later the shipping company. The bike will be delivered insured to your door')}}</p>
                    <p>{{__('In case the bike does not correspond to the specifications in the sale ad, you can return it to us and get your money back')}}</p>

                </div>
                <div id="tab3" class="tab-content">
                    <h2>{{__('Payment')}}</h2>
                    <p>{{__('You pay for the bike online, we manage the payment with our payment service provider Stripe and only when the bike is successfully handed over or shipped, the seller gets his money paid')}}
                        <br>
                        {{__('If a handover does not take place properly, you will get your money refunded directly')}}
                    </p>
                    <h2>{{__('Return')}}</h2>
                    <p>{{__('If the bike does not match the condition of the sale ad when you pick it up, or you are not satisfied during the test ride, you do not have to take the bike and the purchase will be cancelled')}}</p>

                    <p>{{__('If the bike does not match the condition of the sale ad when shipped, you can send it to us and we will refund your money. We will check if there is a discrepancy and take care of the reversal with the seller or necessary repairs.')}}
                        <br>
                        {{__('Please note that if you choose the shipping option, you must contact us within 48h of receiving the bike should you wish to make use of a return')}}
                    </p>
                    <h2>{{__('Shipping')}}</h2>
                    <p>{{__('We ship all bikes with shipping insurance and in case of shipping damage you are covered for the full price of the bike')}}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="disqus-container">
        <h2>{{__('Questions')}}</h2>
        <h3>{{__('Here you can leave your comments or ask questions about the bike')}}</h3>
        @if($bike->user_id != Auth::id())
            <form id="comment_first" action="{{ route('comment') }}" method="post" class="disqus-send-head">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="bike_id" value="{{ $bike->id }}">
                    <textarea name="comment" id="general_comment" class="form-control autosize"
                              placeholder="{{__('Write a questions')}}"></textarea>
                </div>
                @auth
                    <button type="submit" class="btn btn_green">{{__('Submit')}}</button>
                @else
                    <button type="button" data-hystmodal="#login-modal"
                            class="btn btn_green">{{__('Submit')}}</button>
                @endauth
            </form>
        @endif


        <div class="grl">
            @foreach($comments as $key => $comment)
                <figure class="disqus-send">
                    <img src="{{ $comment->user->image_path ?? '/img/profile-user.svg' }}" alt="user_image">
                    <figcaption>
                        <h3>{{$comment->user->name ?? '' }}</h3>
                    </figcaption>
                </figure>

                <p>{{ $comment->body }}</p>

                @if($bike->user_id == Auth::id() || ( Auth::check() && Auth::user()->role == 'admin'))
                    <button type="button" onclick="delete_parent_comment({{ $comment->id }})"
                            class="delete_parent_comment btn-del" aria-label="delete Favorites">
                        <img src="/img/trash.svg" alt="" width="20">
                        {{__('delete')}}
                    </button>
                @endif

                @if($bike->user_id == Auth::id() && !in_array($comment->id, $userComments))

                    <div class="disqus-send-reply-block">
                        <figure class="disqus-send-reply">
                            <img
                                src="{{ Auth::user()->image_path ? Auth::user()->imagePath : '/img/profile-user.svg'}}"
                                alt="user_image">
                            <figcaption>
                                <h3>
                                    {{ Auth::user()->name }}</h3>
                            </figcaption>
                        </figure>

                        <div class=""></div>
                        <form id="reply_comment" action="{{ route('reply.comment') }}"
                              class="disqus-send-head"
                              method="POST">
                            @csrf
                            <div class="form-group">

                                <input type="hidden" name="from_id">
                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                <input type="hidden" name="bike_id" value="{{$comment->commentable_id}}">
                                <textarea name="reply" id="reply" class="form-control autosize"
                                          placeholder="{{__('Write an answer')}}"></textarea>
                            </div>
                            <button type="button"
                                    class="btn btn_green submit_comment_answer_btn"
                            >
                                {{__('Send')}}
                            </button>
                        </form>
                    </div>
                @endif

                @if(isset($commentWithAnswers))
                    <div class="disqus-send-reply-block">
                        @foreach($commentWithAnswers as $answer)

                            @if($comment->id == $answer->parent_id)

                                <figure class="disqus-send-reply">
                                    <img src="{{ $answer->user->image_path ?? '/img/profile-user.svg'}}"
                                         alt="user_image">
                                    <figcaption>
                                        <h3>
                                            {{ $answer->user->name ?? '' }}</h3>
                                    </figcaption>
                                </figure>
                                <p>{{ $answer->body }}</p>

                                @if($bike->user_id == Auth::id())
                                    <button type="button"
                                            onclick="delete_comment({{ $comment->id }}, {{ $answer->id }})"
                                            class="delete_comment btn-del" aria-label="delete Favorites">
                                        <img src="/img/trash.svg" alt="" width="20">
                                        {{__('delete')}}
                                    </button>
                                @endif
                            @endif
                        @endforeach


                    </div>
                @endif
            @endforeach
        </div>

    </div>

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
                            @else
                                <span data-bike_id="{{ $item->id }}"
                                      class="heart-icon"
                                      data-hystmodal="#login-modal"
                                      title="Favorites"></span>
                            @endif
                        </a>

                        <div class="shop-item-info-block">
                            <a href="{{ route('shop.bike', $item->slug) }}"
                               style="text-decoration: none; color: black">
                                <div class="shop-item-title">

                                    <h2 title="{{__('Diverge E5 Base')}}">{{ $item->brand->name ?? '' }}
                                        , {{ $item->name }}</h2>

                                    <div class="form-group checkbox-choose ml-auto" title="{{__('compare')}}">
                                        <input onclick="compare( {{$item->id}} )" type="checkbox"
                                               id="choose{{$item->id}}"
                                               @if(\Illuminate\Support\Facades\Session::get('bike_ids'))
                                               {{ array_key_exists( $item->id, \Illuminate\Support\Facades\Session::get('bike_ids') ) ? 'checked' : '' }}
                                               @endif
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
                            </a>

                            <div class="shop-item-price-block">
                                <div class="shop-item-price">
                                    <p><span>{{ $item->format_price }}</span> €</p>
                                </div>
                                @if(!$item->check_time && !$item->is_sold)
                                    <div class="text-right">
                                        <a href="{{ route('shop.bike', $item->slug) }}"
                                           class="btn btn_green">{{__('Buy Now')}}</a>

                                    </div>
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
                @foreach($veviewed_bikes as $viewed_item)
                    <div class="shop-item">
                        <a href="{{ route('shop.bike', $viewed_item->slug) }}"
                           class="shop-item-img-block">
                            <img
                                src="{{ $viewed_item->image('side') ? $viewed_item->image('side') : $viewed_item->image_path ?? '/img/heco-1.png'}}"
                                alt="{{ $viewed_item->name }}" width="352"
                                height="222"
                                loading="lazy">
                            @if($viewed_item->check_time && !$viewed_item->is_sold)
                                <span class="bike-new"> {{__('Availabe From'). ' '.$viewed_item->check_time}}</span>
                            @endif
                            @if($viewed_item->IsNew && ! $viewed_item->check_time)
                                <span class="bike-new"> {{__('New')}}</span>
                            @endif
                            @if($viewed_item->is_sold)
                                <span class="bike-new"> {{__('Sold')}}</span>
                            @endif
                            @if(Auth::check())
                                <span data-bike_id="{{ $viewed_item->id }}"
                                      class="heart-icon @if(Auth::user()->favorite->contains($viewed_item)) active @endif"
                                      title="Favorites"></span>
                            @else
                                <span data-bike_id="{{ $viewed_item->id }}"
                                      class="heart-icon"
                                      data-hystmodal="#login-modal"
                                      title="Favorites"></span>
                            @endif
                        </a>

                        <div class="shop-item-info-block">
                            <a href="{{ route('shop.bike', $viewed_item->slug) }}"
                               style="text-decoration: none; color: black">
                                <div class="shop-item-title">
                                    <h2 title="{{ $viewed_item->name }}">{{ $viewed_item->brand->name ?? ''}}, {{ $viewed_item->name }}</h2>
                                    <div class="form-group checkbox-choose ml-auto" title="{{__('compare')}}">

                                        <input onchange="compare( {{$viewed_item->id}})" type="checkbox"
                                               @if(\Illuminate\Support\Facades\Session::get('bike_ids'))
                                               {{ array_key_exists( $viewed_item->id, \Illuminate\Support\Facades\Session::get('bike_ids') ) ? 'checked' : '' }}
                                               @endif id="choose_v_{{$viewed_item->id}}" class="form-check-input">
                                        <label for="choose_v_{{$viewed_item->id}}" class="form-check-label">
                                        <span><img src="/img/scale.svg" alt="compare" width="21" height="20"
                                                   loading="lazy"></span>
                                        </label>

                                    </div>
                                </div>

                                <table>
                                    <tr>
                                        <td>{{__('Specialized')}}</td>
                                        <td>{{ $viewed_item->year }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Size')}}</td>
                                        <td>{{ $viewed_item->frame_size }}</td>
                                    </tr>
                                </table>
                            </a>
                            <div class="shop-item-price-block">
                                <div class="shop-item-price">
                                    <p><span>{{ $viewed_item->format_price }}</span> €</p>
                                </div>
                                @if(!$viewed_item->check_time && !$viewed_item->is_sold)
                                    <a href="{{ route('shop.bike', $viewed_item->slug) }}"
                                       class="btn btn_green">{{__('Buy Now')}}</a>
                                @else
                                    <a href="{{ route('shop.bike', $viewed_item->slug) }}"
                                       class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif




    {{--Make a counter offer--}}
    <div class="hystmodal add-bike-modal" id="make-a-counter" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window text-center" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Close</button>

                <form action="{{ route('countery-offer', $bike->id )}}"
                      method="POST">
                    @csrf
                    <h2 class="font-light">{{__('Make counter offer')}}</h2>

                    <div class="form-group">
                        <input min="0" type="number" name="price" placeholder="{{__('Please enter the price')}}"
                               class="form-control"
                               aria-label="">
                    </div>
                    @auth
                        <button type="submit" class="btn btn_green">{{__('Submit')}}</button>
                    @else
                        <a href="#" data-hystmodal="#login-modal"
                           class="btn btn_green">{{__('Buy Now')}}</a>
                    @endauth

                </form>
            </div>
        </div>
    </div>

    {{--bike Size info--}}
    <div class="hystmodal login-modal" id="size-modal2" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center"><b>{{__('The conditions on buycycle 1')}}</b></h2>
                <div>
                    {{__('The conditions on buycycle text 1')}}
                </div>
                <table class="table">
                    <tr>
                        <td>{{__('Frame size')}}</td>
                        <td>{{__('Frame size in cm')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XXS')}}</td>
                        <td>{{__('48')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XS')}}</td>
                        <td>{{__('50')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('S')}}</td>
                        <td>{{__('52')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('M')}}</td>
                        <td>{{__('54')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('L')}}</td>
                        <td>{{__('57')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XL')}}</td>
                        <td>{{__('59')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XXL')}}</td>
                        <td>{{__('62')}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{--bike Condition info--}}
    <div class="hystmodal login-modal" id="frame-info-modal2" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center"><b>{{__('The conditions on buycycle 2')}}</b></h2>
                <div>
                    <p>{{__('The conditions on buycycle text 2')}}</p>
                    <p>{{__('The conditions on buycycle text 2-2')}}</p>

                    <h3 class="mb-0"><b>{{__('Perfekt title')}}</b></h3>
                    <p>{{__('Perfekt text')}}</p>

                    <h3 class="mb-0"><b>{{__('Sehr Gut title')}}</b></h3>
                    <p>{{__('Sehr Gut text')}}</p>

                    <h3 class="mb-0"><b>{{__('Gut title')}}</b></h3>
                    <p>{{__('Gut text')}}</p>

                    <h3 class="mb-0"><b>{{__('OK title')}}</b></h3>
                    <p>{{__('OK text')}}</p>
                </div>
            </div>
        </div>
    </div>

    {{--Purchase advice--}}
    <div id="deliver-option" aria-hidden="true" class="hystmodal login-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window text-center">
                <button data-hystclose="" class="hystmodal__close">Close</button>

                <form action="" id="advice-form">
                    @csrf
                    <h2 class="font-weight-bold">{{__('Purchase advice')}}</h2>
                    <p class="text-center">{{__('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.')}}</p>
                    <br>

                    <div class="form-group">
                        <input type="hidden" name="slug" value="{{$bike->slug}}">
                        <input type="text" name="name" placeholder="{{__('Name')}}" class="form-control"
                               aria-label="{{__('Username')}}" value="{{Auth::user()->name ?? ''}}">
                        <span class="invalid-feedback error-message-name" role="alert"></span>
                    </div>

                    <p>{{__('Choose a way to communicate.')}}</p>

                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="{{__('Phone')}}" class="form-control"
                               aria-label="{{__('Phone')}}" value="{{Auth::user()->phone ?? ''}}">
                        <span class="invalid-feedback error-message-phone" role="alert"></span>
                    </div>

                    <div class="text-in-line"><span>{{__('or')}}</span></div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="{{__('E-mail')}}" class="form-control"
                               aria-label="{{__('E-mail')}}" value="{{Auth::user()->email ?? ''}}">
                        <span class="invalid-feedback error-message-email" role="alert"></span>
                    </div>

                    <div class="text-center">
                        <div class="g-recaptcha text-center d-flex justify-content-center" data-callback="imNotARobot" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                        {{--                    <button type="submit" class="btn btn_green">{{__('send')}}</button>--}}
                        <button class="btn btn_green mt-22 recaptcha-disabled" disabled data-action='submit'>{{__('send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--price modal--}}
    <div id="price-modal" aria-hidden="true" class="hystmodal price-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window">
                <button data-hystclose="" class="hystmodal__close">Close</button>

                <h2>{{__('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.')}}</h2>

                <div class="price-container">
                    <div class="price-item  @if($bike->shipping == 0) price-item-disabled @endif">
                        <h3>{{__('Basic')}}</h3>

                        <div class="price-count price-count-basic">30€</div>

                        <ul class="list-unstyled price-ul">
                            <li class="check-icon">{{__('Secure Payment')}}</li>
                            <li class="check-icon">{{__('Full buycycle warranty')}}</li>
                            <li class="not-icon">{{__('Bike has to be picked up by buyer')}}</li>
                        </ul>

                        <div class="text-center mt-auto">
                            <a href="{{ route('shipping.cart', ['bike_id' => $bike->id, 'package_id'=> 0])}}" class="btn btn_green mr-7">
                                {{__('Buy Now')}}
                            </a>
                            <a href="#"
                               class="btn btn_green disabled mr-7" data-toggle="tooltip" data-placement="top" title="{{__('No Pick-up available for this bike')}}">
                                {{__('Buy Now')}}
                            </a>
                        </div>
                    </div>
                    <div class="price-item price-item-big">
                        <h3>{{__('Premium')}}</h3>

                        <div class="price-count price-count-premium">250€</div>

                        <ul class="list-unstyled price-ul">
                            <li class="check-icon">{{__('Secure Payment')}}</li>
                            <li class="check-icon">{{__('Full buycycle warranty')}}</li>
                            <li class="check-icon">{{__('Insured Shipping')}}</li>
                            <li class="check-icon">{{__('Fast shipping, maximum 1 week shipping time')}}</li>
                            <li class="check-icon">{{__('Complete check by buycycle')}}</li>
                            <li class="check-icon">{{__('All defects and broken parts will be replaced and repaired by buycycle')}}</li>
                            <li class="check-icon">{{__('price text premium')}}</li>
                        </ul>

                        <div class="text-center mt-auto">
                            <a href="{{ route('shipping.cart', ['bike_id' => $bike->id, 'package_id'=>2])}}" class="btn btn_green mr-7">{{__('Buy Now')}}</a>
                        </div>
                    </div>
                    <div class="price-item">
                        <h3>{{__('Plus')}}</h3>

                        <div class="price-count price-count-plus">100€</div>

                        <ul class="list-unstyled price-ul">
                            <li class="check-icon">{{__('Secure Payment')}}</li>
                            <li class="check-icon">{{__('Full buycycle warranty')}}</li>
                            <li class="check-icon">{{__('Insured Shipping')}}</li>
                            <li class="check-icon">{{__('Fast shipping, maximum 1 week')}}</li>
                            <li class="check-icon">{{__('price text plus')}}</li>
                        </ul>

                        <div class="text-center mt-auto">
                            <a href="{{ route('shipping.cart', ['bike_id' => $bike->id, 'package_id'=>1])}}" class="btn btn_green mr-7">{{__('Buy Now')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secure-payment" aria-hidden="true" class="hystmodal shop-single-1-table-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window text-center">
                <button data-hystclose="" class="hystmodal__close">Close</button>
                <img src="/img/Safe-payment.svg" alt="" width="103" height="128" class="mb30">
                <h2 class="font-light">{{__('100% Secure Payment')}}</h2>
                <p>{{__('At buycycle the platform pays and not the buyer, Means if something goes wrong the buyer gets his money back and the seller can be sure that he gets his money and can’t be scammed')}}</p>
                <div class="text-center">
                    <button type="submit" class="btn btn_green" data-hystclose="">{{__('OK')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="buy-without-risk" aria-hidden="true" class="hystmodal shop-single-1-table-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window text-center">
                <button data-hystclose="" class="hystmodal__close">Close</button>
                <img src="/img/Buyer-Protection.svg" alt="" width="103" height="128" class="mb30">
                <h2 class="font-light">{{__('Buy without Risk')}}</h2>
                <p>{{__('If the bike is not how the seller represented it, he can send it back to buycycle and the buyer gets the money back')}}</p>
                <div class="text-center">
                    <button type="submit" class="btn btn_green" data-hystclose="">{{__('OK')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="insured-shipping" aria-hidden="true" class="hystmodal shop-single-1-table-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window text-center">
                <button data-hystclose="" class="hystmodal__close">Close</button>
                <img src="/img/Easy-Shipping.svg" alt="" width="103" height="128" class="mb30">
                <h2 class="font-light">{{__('Insured Shipping')}}</h2>
                <p>{{__('The Seller gets scandalized Packaging and the bike will be picked up from home, So you can sell the bike, without stress, fast and secure')}}</p>
                <div class="text-center">
                    <button type="submit" class="btn btn_green" data-hystclose="">{{__('OK')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="premium-check" aria-hidden="true" class="hystmodal shop-single-1-table-modal">
        <div class="hystmodal__wrap">
            <div role="dialog" aria-modal="true" class="hystmodal__window text-center">
                <button data-hystclose="" class="hystmodal__close">Close</button>
                <img src="/img/Premium-Check.svg" alt="" width="103" height="128" class="mb30">
                <h2 class="font-light">{{__('Premium Check')}}</h2>
                <p>{{__('If wanted the User can pay extra, and the bike will be checked and if needed repaired by buycycle, The user can be sure that, the bike he buys, is completely repaired')}}</p>
                <div class="text-center">
                    <button type="submit" class="btn btn_green" data-hystclose="">{{__('OK')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/lightslider-light-gallery.js"></script>
    <script src="/js/lightgallery.js"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */

        (function () { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://buycicle.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <script id="dsq-count-scr" src="//buycicle.disqus.com/count.js" async></script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
            Disqus.</a></noscript>
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
                        settings: {}
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
                onSliderLoad: function (el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide',
                    });
                }
            });


            var lightSlider = $('.similar-slider').lightSlider({
                item: 3,
                slideMargin: 0,
                pager: false,
                controls: true,
                // autoWidth:true,
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


            autosize();

            function autosize() {
                var text = $('.autosize');
                text.each(function () {
                    $(this).attr('rows', 1);
                    resize($(this));
                });

                text.on('input', function () {
                    resize($(this));
                });

                function resize($text) {
                    $text.css('height', 'auto');
                    $text.css('height', $text[0].scrollHeight + 'px');
                }
            }
        });

        $('#tabs-nav li:first-child').addClass('active');
        $('.tab-content').hide();
        $('.tab-content:first').show();

        $('#tabs-nav li').click(function () {
            $('#tabs-nav li').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();

            var activeTab = $(this).find('a').attr('href');
            $(activeTab).fadeIn();
            return false;
        });

        readMore($('.spoiler'), 4);

        function readMore(jObj, lineNum) {
            if (isNaN(lineNum)) {
                lineNum = 4;
            }
            var go = new ReadMore(jObj, lineNum);
        }

        //class
        function ReadMore(_jObj, lineNum) {
            var READ_MORE_LABEL = '{{__('show more')}}';
            var HIDE_LABEL = '{{__('show less')}}';
            var jObj = _jObj;
            var textMinHeight = '' + (parseInt(jObj.children('.hidden-text').css('line-height'), 10) * lineNum) + 'px';
            var textMaxHeight = '' + jObj.children('.hidden-text').css('height');

            jObj.children('.hidden-text').css('height', '' + textMaxHeight);
            jObj.children('.hidden-text').css('transition', 'height .5s');
            jObj.children('.hidden-text').css('height', '' + textMinHeight);
            if (parseInt(textMaxHeight) > parseInt(textMinHeight)) {
                jObj.append('<a class="read-more" style="cursor: pointer; color: #80be70">' + READ_MORE_LABEL + '</a>');
            }


            jObj.children('.read-more').click(function () {
                if (jObj.children('.hidden-text').css('height') === textMinHeight) {
                    jObj.children('.hidden-text').css('height', '' + textMaxHeight);
                    jObj.children('.read-more').html(HIDE_LABEL).addClass('active');
                } else {
                    jObj.children('.hidden-text').css('height', '' + textMinHeight);
                    jObj.children('.read-more').html(READ_MORE_LABEL).removeClass('active');
                }
            });

            $('#advice-form').submit(function (event) {
                event.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '{{route('purchase.advice')}}',
                    type: "POST",
                    data: data,
                    success: function (data) {
                        console.log('success')
                        location.reload()
                    },
                    error: function (response) {
                        let allErrors = response.responseJSON['errors'];
                            $('.invalid-feedback').html('');
                        for(let i in allErrors){
                            $(`.error-message-${i}`).html(allErrors[i]).css('color', 'red');
                        }
                    }
                });
            });
        }
    </script>
@endsection
