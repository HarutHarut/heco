@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')


    <div class="sell-1-container">
        <h1>{{ $bike->brand->name }}, {{ $bike->name }}, {{ $bike->year }}</h1>
    </div>
    <form action="{{ route('sell.new_bike', $bike->id) }}" method="POST">
        @csrf
        @method('POST')
        <section class="sell-1">
            <div class="sell-1-container">
                <div class="sell-1-form">
                    <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal"><img src="/img/iconsQ2.png" alt="" width="17"
                                                                                height="17"></a>
                        </span>
                        <select name="frame_size" class="minimal @error('frame_size') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Frame size')}}</option>
                            <option {{ old('frame_size') == '43' ? 'selected' : '' }} value="43">43</option>
                            <option {{ old('frame_size') == '44' ? 'selected' : '' }} value="44">44</option>
                            <option {{ old('frame_size') == '45' ? 'selected' : '' }} value="45">45</option>
                            <option {{ old('frame_size') == '46' ? 'selected' : '' }} value="46">46</option>
                            <option {{ old('frame_size') == '47' ? 'selected' : '' }} value="47">47</option>
                            <option {{ old('frame_size') == '48' ? 'selected' : '' }} value="48">48</option>
                            <option {{ old('frame_size') == '49' ? 'selected' : '' }} value="49">49</option>
                            <option {{ old('frame_size') == '50' ? 'selected' : '' }} value="50">50</option>
                            <option {{ old('frame_size') == '51' ? 'selected' : '' }} value="51">51</option>
                            <option {{ old('frame_size') == '52' ? 'selected' : '' }} value="52">52</option>
                            <option {{ old('frame_size') == '53' ? 'selected' : '' }} value="53">53</option>
                            <option {{ old('frame_size') == '54' ? 'selected' : '' }} value="54">54</option>
                            <option {{ old('frame_size') == '55' ? 'selected' : '' }} value="55">55</option>
                            <option {{ old('frame_size') == '56' ? 'selected' : '' }} value="56">56</option>
                            <option {{ old('frame_size') == '57' ? 'selected' : '' }} value="57">57</option>
                            <option {{ old('frame_size') == '58' ? 'selected' : '' }} value="58">58</option>
                            <option {{ old('frame_size') == '59' ? 'selected' : '' }} value="59">59</option>
                            <option {{ old('frame_size') == '60' ? 'selected' : '' }} value="60">60</option>
                            <option {{ old('frame_size') == '61' ? 'selected' : '' }} value="61">61</option>
                            <option {{ old('frame_size') == '62' ? 'selected' : '' }} value="62">62</option>
                            <option {{ old('frame_size') == '63' ? 'selected' : '' }} value="63">63</option>
                            <option {{ old('frame_size') == '64' ? 'selected' : '' }} value="64">64</option>
                        </select>
                        @error('frame_size')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                         <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal2"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                        <select name="condition" class="minimal @error('condition') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Condition')}}</option>

                            {{--                            {{old('business_registration') !== null ? (old('business_registration') == "0" ? 'checked' : '') :--}}
                            {{--                       (isset($business->businessCredentials) ? ($business->businessCredentials->business_registration == "0" ? 'checked' : '') : 'checked')--}}
                            {{--                            <option {{ $bike->condition == 'excellent' ? 'selected' : '' }} value="excellent">{{__('Excellent')}}</option>--}}

                            @foreach(config('enums.CONDITION') as $key => $condition)
                                <option
                                    @if($bike->condition && $bike->condition == $key)
                                    selected
                                    @elseif(old('condition') && old('condition') == $key)
                                    selected
                                    @endif
                                    value="{{$key}}"
                                >
                                    {{__($condition)}}
                                </option>
                            @endforeach

                        </select>
                        @error('condition')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="color-wrapper">
                            <input type="text" name="" placeholder="{{__('Color')}}" id="pickcolor"
                                   value=""   class="form-control call-picker" aria-label="{{__('Color')}}" readonly>
                            <input id="hidden_color" type="hidden" name="color" value="{{old('color', '#000000')}}">
                            <div style="background-color: {{ old('color', '#000000') }}" class="color-holder call-picker"></div>
                            <div class="color-picker" id="color-picker" style="display: none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input min="0" type="number" placeholder="{{__('Price €')}}" name="price"
                               class="form-control @error('price') is-invalid @enderror"
                               aria-label="{{__('Price')}}"
                               value="{{ old('price') ?? '' }}"
                        >
                        @error('price')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="switch">
                            <input @if(!old('fixed')) checked @endif type="radio" name="fixed" id="yes"
                                   value="0" >
                            <label for="yes">{{__('Fixed')}}</label>
                            <input @if(old('fixed')) checked @endif type="radio" name="fixed" id="no"
                                   value="1" >
                            <label for="no">{{__('Negotible')}}</label>
                            <span class="switchFilter"></span>
                        </div>

                    </div>
                    <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal3"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                        <select name="milage" class="minimal @error('milage') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Milage')}}</option>
                            @foreach(config('enums.MILAGE') as $key => $milage)
                                <option
                                    @if(old('milage') && old('milage') == $key)
                                    selected
                                    @endif
                                    value="{{$key}}"
                                >
                                    {{__($milage)}}
                                </option>
                            @endforeach
                        </select>
                        @error('milage')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal4"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                        <select name="last_service" class="minimal @error('last_service') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Last Service')}}</option>
                            @foreach(config('enums.SERVICE') as $key => $service)
                                <option
                                    @if(old('last_service') && old('last_service') == $key)
                                    selected
                                    @endif
                                    value="{{$key}}"
                                >
                                    {{__($service)}}
                                </option>
                            @endforeach
                        </select>
                        @error('last_service')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <select name="preowned" class="minimal @error('preowned') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Was this bike preowned')}}</option>
                            <option {{ old('preowned') == '1' ? 'selected' : '' }} value="1">{{__('Yes')}}</option>
                            <option {{ old('preowned') == '0' ? 'selected' : '' }} value="0">{{__('No')}}</option>
                        </select>
                        @error('preowned')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                          <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal5"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                        <select name="shipping" class="minimal @error('shipping') is-invalid @enderror">
                            <option value="" selected disabled>{{__('Shipping')}}</option>
                            <option
                                {{ old('shipping') == '0' ? 'selected' : '' }} value="0">{{__('Shipping Only')}}</option>
                            <option
                                {{ old('shipping') == '1' ? 'selected' : '' }} value="1">{{__('Shipping or Pick-Up')}}</option>
                        </select>
                        @error('shipping')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input name="location"
                               id="search-address"
                               class="form-control @error('location') is-invalid @enderror"
                               aria-label="{{__('Location')}}"
                               value="{{ old('location') ?? '' }}"
                        >
                        @error('location')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="info" class="form-control" cols="30" rows="3" placeholder="{{__('Info about bike')}}"  aria-label="{{__('Info')}}">{{old('info') ?? '' }}</textarea>
                        @error('info')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn_green mt-22">{{__('Sell this bike')}}</button>
                    </div>
                </div>

                <div class="sell-1-pictures">
                    @foreach($bike->images as $item)
                        <img src="/storage/bikes/{{ $bike->id . '/' . $item->path }}" alt="bikes" width="244"
                             height="230">
                    @endforeach
                </div>
            </div>
        </section>

        <div class="sell-1-components">
            <h2>{{__('Components')}}<br>
                <span>{{__('Click on a component to change it or to report it broken / exchanged')}}</span>
            </h2>
            <table>
                @foreach($details as $item)
                    <tr>
                        <td>
                            <div class="d-flex custom-radio-block">
                                @php
                                    $detail_status = 0;
                                    if(isset($bike)){
                                        $detail_id = 0;
                                        if (in_array($item->id, $bike->bike_settings->pluck('detail_id')->toArray())){
                                            $detail_id = $item->id;
                                        }

                                        if ($detail_id){
                                              $detail_status = $bike->bike_settings()->where('detail_id', $detail_id)->first()->status;
                                        }
                                    }

                                @endphp

                                <div class="radio-grey">
                                    <input type="radio" id="test53{{$item->id}}"
                                           name="{{$item->id}}"
                                           class="custom-radio"
                                           @if(old($item->id) == 0) checked @endif
                                           onclick="toggle({{$item->id}})"
                                           value="0"
                                    >
                                    <label for="test53{{$item->id}}"></label>
                                </div>

                                <div class="radio-green">
                                    <input type="radio" id="test7{{$item->id}}"
                                           name="{{$item->id}}"
                                           class="custom-radio"
                                           onclick="toggle({{$item->id}})"
                                           value="1"
                                           @if(old($item->id) == 1) checked @endif
                                    >
                                    <label for="test7{{$item->id}}"></label>
                                </div>

                                <div class="radio-yellow">
                                    <input type="radio" id="test8{{$item->id}}"
                                           onclick="details({{$item->id}})"
                                           name="{{$item->id}}"
                                           class="custom-radio detail_radio"
                                           value="2"
                                           @if(old($item->id) == 2) checked @endif
                                    >

                                    <label for="test8{{$item->id}}"></label>
                                </div>

                                <div class="radio-red">
                                    <input type="radio" id="test9{{$item->id}}"
                                           name="{{$item->id}}"
                                           class="custom-radio"
                                           onclick="toggle({{$item->id}})"
                                           value="3"
                                           @if(old($item->id) == 3) checked @endif
                                    >
                                    <label for="test9{{$item->id}}"></label>
                                </div>

                            </div>
                        </td>
                        <td><span>{{$item->key ?? ''}}</span>
                        </td>
                        <td class="toggle">
                            @php
                                $value = '';
                                if (isset($bike)){
                                    $detail = $bike->bike_settings()->where('detail_id', $item->id)->first();
                                    if ($detail){
                                        if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                            $value = $detail->note;
                                        }else{
                                            $value = $detail->value;
                                        }
                                    }
                                }
                            @endphp
                            <span id="span_{{ $item->id }}" class="span_{{ $item->id }}">{{ $value }}</span>
                            <input name="details{{$item->id}}" id="details{{$item->id}}" type="text" value="{{old("details$item->id")}}"
                                   style="display: none" class="form-control input_{{$item->id}}">
                            @if(old($item->id) == 2)
                                <script>
                                    document.querySelector('.span_' + '{{ $item->id }}').style.display = 'none';
                                    document.querySelector('.input_' + '{{ $item->id }}').style.display = 'block';
                                </script>
                            @endif

                        </td>
                    </tr>

                @endforeach

            </table>

            <div class="component-info">
                <div><span class="circle circle-grey"></span> {{__('default parts')}}</div>
                <div><span class="circle circle-green"></span> {{__('Replaced parts')}}</div>
                <div><span class="circle circle-yellow"></span> {{__('Changed parts')}}</div>
                <div><span class="circle circle-red"></span> {{__('Broken parts')}}</div>
            </div>
        </div>
    </form>

    <div class="hystmodal login-modal" id="frame-info-modal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 1')}}</b></h3>
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
                <p>{{__('Solltest du trotzdem nicht sicher sein, welche Rahmengröße dein Rad hat, schreib uns doch einfach eine Mail an')}}
                    <a href="mailto:info@buycycle.de">info@buycycle.de</a></p>
            </div>
        </div>
    </div>

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

    <div class="hystmodal login-modal" id="frame-info-modal3" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 3')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 3')}}
                </div>
            </div>
        </div>
    </div>

    <div class="hystmodal login-modal" id="frame-info-modal4" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 4')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 4')}}
                </div>
            </div>
        </div>
    </div>

    <div class="hystmodal login-modal" id="frame-info-modal5" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 5')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 5')}}
                </div>
            </div>
        </div>
    </div>

    <div class="hystmodal login-modal" id="login-modal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center modal-title">{{__('Sign Up')}}</h2>

                <div class="login-other d-flex flex-wrap">
                    <a href="{{ route('login.provider',['provider' => 'facebook']) }}" class="btn-facebook">
                        <img src="/img/facebook-w.png" alt="Facebook" width="11" height="20" loading="lazy">Facebook
                    </a>
                    <a href="{{ route('login.provider',['provider' => 'google']) }}" class="btn-gmail">
                        <img src="/img/gmail.png" alt="Gmail" width="17" height="13" loading="lazy">Gmail
                    </a>
                    <a href="#" class="btn-apple">
                        <img src="/img/apple.png" alt="Apple" width="16" height="20" loading="lazy">Apple
                    </a>
                </div>

                <div class="text-in-line"><span>{{__('or')}}</span></div>

                <form id="login_form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="font-light text-center">{{__('Log In')}}</h2>

                    <div class="form-scroll">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="{{__('E-mail')}}"
                                   class="form-control login_email"
                                   aria-label="E-mail">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="{{__('Password')}}"
                                   class="form-control login_password"
                                   aria-label="Password">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>

                        <div class="d-flex align-items-center remember-block">
                            <div class="form-group custom-checkbox">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck2">{{__('Remember me')}}</label>
                            </div>
                            <a href="{{ route('password.request') }}"
                               class="login-link ml-auto">{{__('Forgot your password?')}}</a>
                        </div>
                        <a href="#" data-hystmodal="#register-modal">{{__('Register Now')}}</a>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn_green">{{__('Log In')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="hystmodal login-modal" id="register-modal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center modal-title">{{__('Please Register')}}</h2>

                <div class="login-other d-flex flex-wrap">
                    <a href="{{ route('login.provider',['provider' => 'facebook']) }}" class="btn-facebook">
                        <img src="/img/facebook-w.png" alt="Facebook" width="11" height="20" loading="lazy">Facebook
                    </a>
                    <a href="{{ route('login.provider',['provider' => 'google']) }}" class="btn-gmail">
                        <img src="/img/gmail.png" alt="Gmail" width="17" height="13" loading="lazy">Gmail
                    </a>
                    <a href="#" class="btn-apple">
                        <img src="/img/apple.png" alt="Apple" width="16" height="20" loading="lazy">Apple
                    </a>
                </div>

                <div class="text-in-line"><span>{{__('or')}}</span></div>

                <form id="registration_form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-scroll">
                        <div class="form-group">
                            <input type="text" name="first_name" placeholder="{{__('First Name')}}"
                                   class="form-control registration_name"
                                   aria-label="Username">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" placeholder="{{__('Last Name')}}"
                                   class="form-control registration_name"
                                   aria-label="Username">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="{{__('E-mail')}}"
                                   class="form-control registration_email"
                                   aria-label="E-mail">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="{{__('Phone')}}"
                                   class="form-control registration_phone tel-input"
                                   aria-label="Phone">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="{{__('Password')}}"
                                   class="form-control registration_password"
                                   aria-label="Password">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="{{__('Confirm Password')}}"
                                   class="form-control registration_password_confirmation"
                                   aria-label="Password" autocomplete="new-password">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn_green">{{__('Register')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&libraries=places"></script>
    <script>
        $(document).ready(function() {
            $('.minimal').select2();
        });

        function initialize() {
            var ac = new google.maps.places.Autocomplete(document.getElementById('search-address'));
            ac.setComponentRestrictions(
                {'country': ['DE'], 'postalCode': []});
        }

        $(function () {
            initialize();
        });

        function details(id) {
            let span_class = '.span_' + id;
            let input_details = '.input_' + id;
            $(`${span_class}`).hide();
            $(`${input_details}`).show();

        };

        function toggle(id) {
            let span_class = '.span_' + id;
            let input_details = '.input_' + id;
            if (input_details) {
                $(`${span_class}`).show();
                $(`${input_details}`).hide();
            }
        };

        $(document).ready(function () {
            var $parent,
                windowWidth,
                windowHeight;

            function winSize() {
                windowWidth = $(window).width(),
                    windowHeight = $(window).height();
            }

            winSize();
            $(window).resize(winSize);
            $('.drag-tooltip').each(function () {

                $(this).parent().hover(function () {
                    $(this).find('.drag-tooltip').fadeIn('fast');
                }, function () {
                    $(this).find('.drag-tooltip').fadeOut('fast');
                });

            });

            $(document).mousemove(function (e) {
                var mouseY = e.clientY,
                    mouseX = e.clientX,
                    tooltipHeight,
                    tooltipWidth;

                $('.drag-tooltip').each(function () {
                    var $tooltip = $(this);
                    tooltipHeight = $tooltip.outerHeight();
                    tooltipWidth = $tooltip.width();
                    $parent = $tooltip.parent();

                    $tooltip.css({
                        'left': mouseX,
                        'top': mouseY + 20
                    });

                    if (tooltipWidth + mouseX + 20 > windowWidth) {
                        $tooltip.css({
                            'left': mouseX - tooltipWidth - 20
                        });
                    }

                    if (tooltipHeight + mouseY + 20 > windowHeight) {
                        $tooltip.css({
                            'top': mouseY - 20 - tooltipHeight
                        });
                    }
                });
            });
        });


        var colorList = [ '000000', 'FFFFFF', 'ff0000', 'ffff00', '008000', '0000ff', 'ffa500', '800080',
            '808080' ];
        var picker = $('#color-picker');

        for (var i = 0; i < colorList.length; i++ ) {
            picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
        }

        $('body').click(function () {
            picker.hide();
        });


        $('.call-picker').click(function(event) {
            event.stopPropagation();
            picker.show();
            picker.children('li').hover(function() {
                var codeHex = $(this).data('hex');
                $('.color-holder').css('background-color', codeHex,);
               $('#hidden_color').val(codeHex);
            });
        });
    </script>
@endsection

