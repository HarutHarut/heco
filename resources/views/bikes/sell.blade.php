@extends('layouts.app')

@section('PageCss')
    <link href="/css/slick.css" rel="stylesheet"/>
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
    <style>
        .text-white {
            color: white;
            font-weight: bold;
        }

        .structured-search-form .form-control {
            background-color: white;
        }
    </style>
@endsection

@section('content')

    <div class="sell-section">
        <section class="structured-slider-section">

            <div class="structured-slider-container">
                <div class="structured-slider">
                    <div>
                        <div class="structured-slider-item-user">
                            <img src="/img/Safe-payment.svg" alt="{{__('sell slide title1')}}" width="71" height="88">
                            <div class="structured-slider-item-user-name">
                                <h2>{{__('sell slide title1')}}</h2>
                                <p>{{__('sell slide text1')}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="structured-slider-item-user">
                            <img src="/img/Easy-Shipping.svg" alt="{{__('sell slide title2')}}" width="71" height="88">
                            <div class="structured-slider-item-user-name">
                                <h2>{{__('sell slide title2')}}</h2>
                                <p>{{__('sell slide text2')}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="structured-slider-item-user">
                            <img src="/img/Buyer-Protection.svg" alt="{{__('sell slide title3')}}" width="71" height="88">
                            <div class="structured-slider-item-user-name">
                                <h2>{{__('sell slide title3')}}</h2>
                                <p>{{__('sell slide text3')}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="structured-slider-item-user">
                            <img src="/img/Structure2.svg" alt="{{__('sell slide title4')}}" width="71" height="88">
                            <div class="structured-slider-item-user-name">
                                <h2>{{__('sell slide title4')}}</h2>
                                <p>{{__('sell slide text4')}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="structured-slider-item-user">
                            <img src="/img/One-Click2.svg" alt="{{__('sell slide title5')}}" width="71" height="88">
                            <div class="structured-slider-item-user-name">
                                <h2>{{__('sell slide title5')}}</h2>
                                <p>{{__('sell slide text5')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <section class="structured-search">
            <form action="{{ route('sell.select') }}" method="GET" class="structured-search-form">
                <h2 class="font-light">{{__('What is your dream bike')}}?</h2>
                <div class="form-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="{{__('Search for your bike here')}}">
                    @error('search')
                    <span style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select id="years_search_select" class="minimal @error('model') is-invalid @enderror" name="search_year">
                        <option value="">{{__('Year')}}</option>
                        @foreach($years as $year)
                            <option value="{{$year}}">{{$year}}</option>
                        @endforeach
                    </select>
                    @error('year')
                    <span style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <h2 class="text-center text-white">OR</h2>
                <div class="form-group">
                    <select id="years_select" class="minimal @error('model') is-invalid @enderror" name="year">
                        <option value="">{{__('Year')}}</option>
                        @foreach($years as $year)
                            <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                    </select>
                    @error('year')
                    <span style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select id="brand_select" class="minimal @error('brand') is-invalid @enderror" name="brand">
                        <option value="">{{__('Brand')}}</option>
                        @foreach($brands as $brand)
                            <option @if(isset(request()->brand_id) && request()->brand_id == $brand->id) selected
                                    @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand')
                    <span style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select id="models_select" class="minimal @error('model') is-invalid @enderror" name="model">
                        <option value="">{{__('Model')}}</option>
                    </select>
                    @error('model')
                    <span style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn_green">{{__('Lets go')}}</button>
                <a href="#" class="btn btn_green" data-hystmodal="#add-my-bike">{{__('My bike is not listed')}}</a>

                <a href="#" data-hystmodal="#so-function" class="btn btn_grey_light">{{__('so function')}}</a>
            </form>

            <picture class="structured-bg">
                <source srcset="/img/structured-bg-2.webp" type="image/webp">
                <source srcset="/img/structured-bg-2.jpg" type="image/jpg">
                <img src="/img/structured-bg-2.jpg" alt="structured" width="1920" height="455">
            </picture>

        </section>

        <div class="hystmodal add-bike-modal" id="add-my-bike" aria-hidden="true">
            <div class="hystmodal__wrap">
                <div class="hystmodal__window text-center" role="dialog" aria-modal="true">
                    <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                    <form action="{{ route('add_my_bike') }}" method="POST" id="add_bike_form">
                        @csrf
                        <h2 class="font-light">{{__('Add my bike')}}</h2>
                        <p>{{__('We are sorry that you can not find your bike')}}</p>
                        <p>{{__('We are constantly working to expand our database. Just tell us which bike is still missing')}}</p>
                        <br>
                        <div class="form-group">
                            <input type="text" name="brand_recomm" placeholder="{{__('Brand')}}" class="form-control"
                                   aria-label="Brand">
                            <span class="invalid-feedback brand_recomm text-left"></span>

                        </div>
                        <div class="form-group">
                            <input type="text" name="model_recomm" placeholder="{{__('Model')}}" class="form-control"
                                   aria-label="Model">
                            <span class="invalid-feedback model_recomm text-left"></span>

                        </div>
                        <div class="form-group">
                            <input type="text" name="year_recomm" placeholder="{{__('Year')}}" class="form-control"
                                   aria-label="Year">
                            <span class="invalid-feedback year_recomm text-left"></span>

                        </div>
                        <div class="form-group">
                            <input type="email" name="email_recomm" placeholder="{{__('E-mail')}}" class="form-control"
                                   aria-label="E-mail">
                            <span class="invalid-feedback email_recomm text-left"></span>

                        </div>
                        <div class="g-recaptcha text-center d-flex justify-content-center" data-callback="imNotARobot" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                        <button type="submit" disabled class="btn btn_green recaptcha-disabled">{{__('Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="hystmodal so-modal" id="so-function" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>
                <h2 class="text-center">{{__('So einfach stellst')}}</h2>
                <div class="so-modal-item">
                    <img src="/img/Search.svg" alt="{{__('so title1')}}" width="71" height="88">
                    <div class="flex-grow-1">
                        <h3>{{__('so title1')}}</h3>
                        <p>{{__('so text1')}}</p>
                    </div>
                </div>
                <div class="so-modal-item">
                    <img src="/img/Condition.svg" alt="{{__('so title2')}}" width="71" height="88">
                    <div class="flex-grow-1">
                        <h3>{{__('so title2')}}</h3>
                        <p>{{__('so text2')}}</p>
                    </div>
                </div>
                <div class="so-modal-item">
                    <img src="/img/Pictures.svg" alt="{{__('so title3')}}" width="71" height="88">
                    <div class="flex-grow-1">
                        <h3>{{__('so title3')}}</h3>
                        <p>{{__('so text3')}}</p>
                    </div>
                </div>
                <div class="so-modal-item">
                    <img src="/img/Information-and-Components.svg" alt="{{__('so title4')}}" width="71" height="88">
                    <div class="flex-grow-1">
                        <h3>{{__('so title4')}}</h3>
                        <p>{{__('so text4')}}</p>
                    </div>
                </div>
                <div class="so-modal-item">
                    <img src="/img/Confirmation-&-Pay out.svg" alt="{{__('so title5')}}" width="71" height="88">
                    <div class="flex-grow-1">
                        <h3>{{__('so title5')}}</h3>
                        <p>{{__('so text5')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/slick.js"></script>
    <script>

        $(document).ready(function(){
            $('.structured-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: false,
                prevArrow:"<button type='button' class='slick-prev'><div class=\"long-arrow-left\"></div></button>",
                nextArrow:"<button type='button' class='slick-next'><div class=\"long-arrow-right\"></div></button>",
                // autoplay: true,
                // autoplaySpeed: 2000,
            });
        });


        $('#brand_select').select2({});
        $('#models_select').select2({});
        $('#years_select').select2({});
        $('#years_search_select').select2({});

        $('#brand_select').change(function () {
            let val = $(this).find(':selected').val();
            if (val) {
                changeBrand(val)
            }
        });


        $('#years_select').change(function () {
            let val = $(this).find(':selected').val();
            if (val) {
               changeYear(val)
            }else{
                $("#brand_select").empty();
                $("#brand_select").append($(`<option value="">{{__('Brand')}}</option>`));
                @foreach($brands as $brand)
                $("#brand_select").append($('<option  value="{{$brand->id}}">{{$brand->name}}</option>'));
                @endforeach
            }
        });


        function changeYear(val){
            $.ajax({
                url: '/get-sell-2/' + val,
                type: "GET",
                data: {},
                success: function (data) {
                    $("#brand_select").empty();
                    $("#brand_select").append($(`<option value="">{{__('Brand')}}</option>`));
                    for (let i = 0; i < data.length; i++) {
                        $("#brand_select").append($(`<option  value="${data[i].id}">${data[i].name}</option>`));
                    }
                },
            });
        }

        function changeBrand(val) {
            $.ajax({
                url: '/get-sell-1/' + val,
                type: "GET",
                data: {
                    year:  $("#years_select").find(':selected').val()
                },
                success: function (data) {
                    $("#models_select").empty();
                    $("#models_select").append($(`<option value="">{{__('Model')}}</option>`));
                    for (let i = 0; i < data.length; i++) {
                        $("#models_select").append($(`<option  value="${data[i].id}">${data[i].name}</option>`));
                    }

                    @if(request()->get('model_id'))
                    $("#models_select").val('{{request()->get('model_id')}}')
                    @endif
                },
            });
        }

        @if(request()->get('brand_id'))
            changeBrand('{{request()->get('brand_id')}}')
        @endif

    </script>
@endsection



