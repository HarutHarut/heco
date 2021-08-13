@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/compare.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="compare">
        @if(!$bike_1 && !$bike_2)
            <br>
            <h2 class="font-weight-normal">{{__('Note Comparison')}}</h2>
            <h2 class="font-weight-normal">{{__('Note Comparison 2')}}</h2>
        @else
            <h1>{{__('Your Comparison')}}</h1>
            <div class="compare-table-block">
                <table class="compare-table">
                    <thead>
                    <tr>
                        <th></th>
                        @isset($bike_1)
                            <td>
                                <div class="compare-table-img">
                                    <div class="position-relative">
                                        <img
                                            src="{{ $bike_1->image('side') ? $bike_1->image('side') : $bike_1->image_path ?? '/img/heco-3.jpg' }}"
                                            alt="">
                                        @if($bike_1)
                                            <button type="button" class="close-icon"
                                                    onclick="compare({{ $bike_1->id }})"
                                                    aria-label="delete compare"></button>
                                        @endif
                                        @if(!$bike_1->check_time && !$bike_1->is_sold)
                                            <a href="{{ route('shop.bike', $bike_1->slug ?? '') }}"
                                               class="btn btn_green">{{__('Buy Now')}}</a>
                                        @else
                                            <a href="{{ route('shop.bike', $bike_1->slug ?? '') }}"
                                               class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                        @endif
                                    </div>
                                    <h2>{{ $bike_1->name ?? '-' }}</h2>
                                    <p>{{ $bike_1->year ?? '-' }}</p>
                                </div>
                            </td>
                        @endisset

                        @isset($bike_2)
                            <td class="not-none">
                                <div class="compare-table-img">
                                    <div class="position-relative">
                                        <img
                                            src="{{ $bike_2->image('side') ? $bike_2->image('side') : $bike_2->image_path  ?? '/img/heco-3.jpg' }}"
                                            alt="">
                                        @if($bike_2)
                                            <button type="button" class="close-icon"
                                                    onclick="compare({{ $bike_2->id ?? ''}})"
                                                    aria-label="delete compare"></button>
                                        @endif

                                        @if(!$bike_2->check_time && !$bike_2->is_sold)
                                            <a href="{{ route('shop.bike', $bike_2->slug ?? '') }}"
                                               class="btn btn_green">{{__('Buy Now')}}</a>
                                        @else
                                            <a href="{{ route('shop.bike', $bike_2->slug ?? '') }}"
                                               class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                        @endif
                                    </div>
                                    <h2>{{ $bike_2->name ?? '-' }}</h2>
                                    <p>{{ $bike_2->year ?? '-' }}</p>
                                </div>
                            </td>
                        @endisset
                    </tr>
                    </thead>

                    <tr>
                        <th>{{__('MSRP')}}</th>
                        <td data-label="{{ $bike_1->msrp ?? '-' }} €">{{ $bike_1->msrp ?? '-' }} €</td>
                        <td data-label="{{ $bike_2->msrp ?? '-' }} €">{{ $bike_2->msrp ?? '-' }} €</td>
                    </tr>
                    <tr>
                        <th>{{__('Frame Size')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">{{ $bike_1->frame_size ?? '-' }}</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">{{ $bike_2->frame_size ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Price')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">{{ $bike_1->format_price ?? '-' }} €</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">{{ $bike_2->format_price ?? '-' }} €</td>
                    </tr>
                    <tr>
                        <th>{{__('Condition')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">{{ __($bike_1->condition) ?? '-' }}</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">@isset($bike_2->condition){{ __($bike_2->condition) }}@else - @endisset</td>
                    </tr>
                    <tr>
                        <th>{{__('Mileage')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">{{ $bike_1->milage ?? '-' }}</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">{{ $bike_2->milage ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Last Service')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">{{ __($bike_1->last_service) ?? '-' }}</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">@isset($bike_2->last_service){{ __($bike_2->last_service) }}@else - @endisset</td>
                    </tr>
                    <tr>
                        <th>{{__('Preowned')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">@if(isset($bike_1->preowned)){{$bike_1->preowned ? __('Yes') : __('No')}}@endif</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">@if(isset($bike_2->preowned)){{ $bike_2->preowned ? __('Yes') : __('No') }} @endif</td>
                    </tr>
                    <tr>
                        <th>{{__('Shipping')}}</th>
                        <td data-label="{{ $bike_1->name ?? '' }}">@if(isset($bike_1->shipping)){{ $bike_1->shipping ? __('Shipping or Pick-Up') : __('Shipping Only')  }}@endif</td>
                        <td data-label="{{ $bike_2->name ?? '' }}">@if(isset($bike_2->shipping)){{ $bike_2->shipping ? __('Shipping or Pick-Up') : __('Shipping Only') }}@endif</td>
                    </tr>

                    <tr>
                        <th>{{__('Category')}}</th>
                        <td>
                            @if($bike_1)
                                @foreach($bike_1->category as $category_1)
                                    {{ $category_1->name ?? '-' }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($bike_2)
                                @foreach($bike_2->category as $key => $category_2 )
                                    @if($key == count($bike_2->category)-1)
                                        {{ $category_2->name ?? '-' }}
                                    @else
                                        {{ $category_2->name ?? '-' }},
                                    @endif
                                @endforeach
                            @endif

                        </td>

                        {{--                    <td data-label="{{ $bike_1->category ?? '' }}">{{ $category_1 ?? '-' }}</td>--}}
                        {{--                    <td data-label="{{ $category_2 ?? '' }}">{{ $category_2 ?? '-' }}</td>--}}
                    </tr>

                    <tr>
                        <th>{{__('Weight')}}</th>
                        <td data-label="{{ $bike_1->weight ?? '' }}">{{ $bike_1->weight ?? '-' }}</td>
                        <td data-label="{{ $bike_2->weight ?? '' }}">{{ $bike_2->weight ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td data-label="{{ $bike_1->country->country ?? '' }}">{{ $bike_1->country->country ?? '-' }}</td>
                        <td data-label="{{ $bike_2->country->country ?? '' }}">{{ $bike_2->country->country ?? '-' }}</td>
                    </tr>
                    @foreach($details as $item)
                        @php
                            $value_1 = '-';
                            $value_2 = '-';
                            if ($bike_1){
                                $detail = $bike_1->bike_settings()->where('detail_id', $item->id)->first();
                                if ($detail){
                                    if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                        $value_1 = $detail->note;
                                    }else{
                                        $value_1 = $detail->value;
                                    }
                                }
                            }
                            if ($bike_2){
                                $detail = $bike_2->bike_settings()->where('detail_id', $item->id)->first();
                                if ($detail){
                                    if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                        $value_2 = $detail->note;
                                    }else{
                                        $value_2 = $detail->value;
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <th>{{ __($item->key) }}</th>
                            <td data-label="{{ $value_1 ?? '' }}">{{ $value_1 ?? '-' }}</td>
                            <td data-label="{{ $value_2 ?? '' }}">{{ $value_2 ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </section>

@endsection
