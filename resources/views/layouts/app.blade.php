<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {!! SEO::generate() !!}
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="Description" content="Description">
    <meta name="keyword" content="@yield('keywords')">
    <meta name="description" content="@yield('descriptions')">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Buycycle') }}</title>

    <link href="{{mix('/css/app-front.css')}}" rel="stylesheet">

    <script>
        window.trans = <?php
        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            if (pathinfo($f)['filename'] == '__shop__') {
                $trans[$filename] = trans($filename);
            }
        }

        echo json_encode($trans);
        ?>;
    </script>
    @if(config('app.env') == 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PW8CCL3J50"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-NZSXET729M');
        </script>
    @endif
    @yield('PageCss')
</head>

<body>

<div id="app" class="page-wraper">
    <nav class="my-nav">
        <div class="navbar d-flex align-items-center">

            <a class="navbar-brand" href="{{route('home')}}" aria-label="eorbit logo">
                <img src="/img/logo.png" alt="buycycle" width="279" height="52">
            </a>
            @if(!\Illuminate\Support\Facades\Auth::check())
                <div class="navbar-login-buttons">
                    <a href="#" class="btn btn_green" data-hystmodal="#login-modal">{{__('Login')}}</a>
                    <a href="#" class="btn btn_green" data-hystmodal="#register-modal">{{__('Register')}}</a>
                </div>
            @endif

            <ul class="navbar-links">
{{--                <li><a href="{{ route('buy') }}">{{__('Buy')}}</a></li>--}}
                <li><a href="{{ route('shop.index') }}">{{__('Buy')}}</a></li>
                <li><a href="{{ route('sell') }}">{{__('Sell')}}</a></li>
            </ul>

            @if(\Illuminate\Support\Facades\Auth::check())
                <ul class="navbar-icons">
                    <li>
                        <a href="{{ route('favorites') }}" aria-label="favorites" title="favorites">
                            <img src="/img/favorites.svg" alt="" width="26" height="23">
                            <span id="favorites_count" class="favorites_count" value="">{{ $count }}</span>
                        </a>
                    </li>

                    <li class="compaireShow" style="display: @if($compaire_count != 0) block @else none @endif">
                        <a href="{{ route('compaire.index') }}" aria-label="compaire" title="compaire">
                            <img src="/img/compaire.svg" alt="" width="29" height="28">
                            <span id="compaire_count">{{ $compaire_count }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('notifications') }}" aria-label="notifications" title="notifications">
                            <img src="/img/noty.svg" alt="" width="22" height="25">
                            <span>{{ $notification_count }}</span>
                        </a>
                    </li>
                </ul>
            @else
                <ul class="navbar-icons">
                    <li class="compaireShow" style="display: @if($compaire_count != 0) block @else none @endif">
                        <a href="{{ route('compaire.index') }}" aria-label="compaire" title="compaire">
                            <img src="/img/compaire.svg" alt="compaire" width="29" height="28">
                            <span id="compaire_count">{{ $compaire_count }}</span>
                        </a>
                    </li>
                </ul>
            @endif
            @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{ route('personal-information.index') }}" aria-label="User image" class="nav-user"
                   title="user name">
                    <img
                        src="{{ Auth::user()->image_path ? Auth::user()->imagePath : '/img/user.svg' }}"
                        alt="" width="30" height="30">
                </a>
            @endif

            <div class="navbar-menu">
                <button type="button" id="open-menu">
                    <img src="/img/burger.svg" alt="" width="37" height="23">
                </button>
                <div class="navbar-menu-container">

                    <div class="navbar-menu-block">
                        <button type="button" id="close-menu" aria-label="close menu">
                            <span class="close-icon"></span>
                        </button>

                        @if(\Illuminate\Support\Facades\Auth::check())
                            <a href="{{ route('personal-information.index') }}" aria-label="User image"
                               class="nav-user-mobile"
                               title="user name">
                                <img
                                    src="{{ Auth::user()->image_path ? Auth::user()->imagePath : '/img/user.svg' }}"
                                    alt="user" width="30" height="30">
                            </a>
                        @endif

                        <ul class="navbar-menu-links">

                            @auth
                                @if( auth()->user()->userRoles('admin'))
                                    <li><a href="/dashboard">{{__('Dashboard')}}</a></li>
                                @endif
                                <li><a href="{{route('personal-information.index')}}">{{__('My Profile')}}</a></li>
                            @endauth
                            <li><a href="{{route('what_we_do')}}">{{__('What we do')}}</a></li>
                            <li><a href="{{route('about')}}">{{__('About us')}}</a></li>

                            <li><a href="{{ route('contact.index') }}">{{__('Contact us')}}</a></li>

                            <li><a href="{{route('blog.index')}}">{{__('Blog')}}</a></li>
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <li><a href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @endif

                        </ul>

                        <ul class="navbar-lang">
                            <li>
                                <a class="dropdown-toggle" aria-label="user profile">
                                    <img
                                        src="{{m_lang_icon_path(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())}}"
                                        alt="language" width="19" height="19">
                                    <span>{{__('auth.'.\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())}}</span>
                                    <b class="drop-arrow ml-auto"></b>
                                </a>
                                @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localCode => $langItem)
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() != $localCode)
                                        <ul class="dropdown">
                                            <li>
                                                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localCode, null, [], true) }}"
                                                   aria-label="language">
                                                    <img src="{{m_lang_icon_path($localCode)}}" alt="language"
                                                         width="19" height="19">
                                                    <span>{{__('auth.'.$localCode)}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    @endif
                                @endforeach
                            </li>
                        </ul>

                        @if(!\Illuminate\Support\Facades\Auth::check())
                            <div class="ml-auto navbar-login-buttons-mobile">
                                <a href="#" class="btn btn_green" data-hystmodal="#login-modal">{{__('Login')}}</a>
                                <a href="#" class="btn btn_green"
                                   data-hystmodal="#register-modal">{{__('Register')}}</a>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <footer>
        <div class="footer-container position-relative d-flex align-items-start flex-wrap justify-content-between">

            <div class="footer-logo">
                <a class="navbar-brand" href="#">
                    <img src="/img/logo-footer.png" alt="buycycle" width="277" height="52">
                </a>
                <p class="mb-2">{{__('Supported by:')}}</p>
                <a href=" https://www.german-entrepreneurship.de" target="_blank" rel="noopener" aria-label="LMU"
                   class="lmu">
                    <picture>
                        <source srcset="/img/LMU.webp" type="image/webp">
                        <source srcset="/img/LMU.png" type="image/png">
                        <img src="/img/LMU.png" width="274" height="60" class="img-fluid" alt="LMU">
                    </picture>
                </a>

            </div>
            <div class="footer-links">
                <p>{{__('About Us')}}</p>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('sell') }}">{{__('Sell')}}</a></li>
{{--                    <li><a href="{{ route('buy') }}">{{__('Buy')}}</a></li>--}}
                    <li><a href="{{ route('shop.index') }}">{{__('Buy')}}</a></li>
                    <li><a href="{{route('blog.index')}}">{{__('Blog')}}</a></li>
                    <li><a href="{{ route('contact.index') }}">{{__('Contact')}}</a></li>
                </ul>
            </div>
            <div class="footer-address">
                <p>{{__('Contact Us')}}</p>
                <address class="mb-0">
                    <div class="address-item">
                        <p>{{__('Phone')}}</p>
                        <a href="tel:{{__('+49 172 4582838')}}" class="mr-2">{{__('+49 172 4582838')}}</a>
                    </div>
                    <div class="address-item d-flex align-items-start">
                        <div class="address-item-info">
                            <p>{{__('Email')}}</p>
                            <a href="mailto:{{__('info@buycycle.de')}}" class="mr-2">{{__('info@buycycle.de')}}</a>
                        </div>
                    </div>
                    <div class="address-item d-flex align-items-start">
                        <div class="address-item-info">
                            <p>{{__('Address')}}</p>
                            <span>{{__('Ansbacher Str. 5')}}</span><br>
                            <span>{{__('80796 Munich')}}</span><br>
                            <span>{{__('Germany')}}</span>
                        </div>
                    </div>
                </address>
            </div>
            <div class="footer-follow">
                <p>{{__('Follow us at:')}}</p>
                <div class="footer-socials d-flex">
                    <a href="https://www.facebook.com/buycyclede-108366184681694" rel="noreferrer" target="_blank"
                       title="" aria-label="facebook" data-toggle="tooltip"
                       data-original-title="facebook">
                        <img src="/img/facebook.svg" alt="facebook" class="opacity-img" loading="lazy" width="17"
                             height="17">
                    </a>
                    <a href="https://www.instagram.com/buycycle_de/" rel="noreferrer" target="_blank" title=""
                       aria-label="instagram" data-toggle="tooltip"
                       data-original-title="instagram">
                        <img src="/img/instagram.svg" alt="instagram" class="opacity-img" loading="lazy" width="17"
                             height="17">
                    </a>
                </div>
            </div>

            <div class="w-100 copyright-container d-flex flex-wrap justify-content-between align-items-center">
                <p class="mb-0">{{__('Copyright ©B U Y C Y C L E 2020 Company  All rights reserved')}}</p>
                <ul class="list-unstyled d-flex mb-0 flex-wrap">
                    <li><a href="{{route('impressum')}}">{{__('Impressum')}}</a></li>
                    <li><a href="{{route('terms')}}">{{__('Terms of Use')}}</a></li>
                    <li><a href="{{route('privacy')}}">{{__('Privacy Policy')}}</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>

<div class="hystmodal login-modal" id="login-modal" aria-hidden="true">
    <div class="hystmodal__wrap">
        <div class="hystmodal__window" role="dialog" aria-modal="true">
            <button data-hystclose class="hystmodal__close">Close</button>

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
                        <input type="email" name="email" placeholder="{{__('E-mail')}}" class="form-control login_email"
                               aria-label="E-mail">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="{{__('Password')}}"
                               class="form-control login_password"
                               aria-label="Password">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>

                    <div class="d-flex align-items-center flex-wrap remember-block">
                        <div class="form-group custom-checkbox">
                            <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck2">
                            <label class="form-check-label" for="exampleCheck2">{{__('Remember me')}}</label>
                        </div>
                        <a href="{{ route('password.request') }}"
                           class="login-link ml-auto">{{__('Forgot your password?')}}</a>
                    </div>
                    <div class="text-right">
                        <a href="#" class="login-link" data-hystmodal="#register-modal">{{__('Register Now')}}</a>
                    </div>
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
                               class="form-control registration_first_name"
                               aria-label="Username">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" placeholder="{{__('Last Name')}}"
                               class="form-control registration_last_name"
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
                        <input type="tel" name="phone"
                               class="form-control registration_phone tel-input" placeholder="{{__('Phone')}}"
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
                <div class="form-group custom-checkbox">
                    <input type="checkbox" class="form-check-input registration_agree" name="agree" id="agree" required>
                    <label class="form-check-label" for="agree">
                        {{__('i agree to')}}
                        <a href="{{route('terms')}}" target="_blank">{{__('Terms of Use')}}</a>
                        {{__('and')}}
                        <a href="{{route('privacy')}}" target="_blank">{{__('Privacy Policy')}}</a>
                        <span class="en-d-none">zu.</span>
                    </label>
                    <br>
                    <span class="invalid-feedback" role="alert"></span>
                </div>
                <div class="text-center">
                    <div class="g-recaptcha text-center d-flex justify-content-center" data-callback="imNotARobot" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                    <button class="btn btn_green spinner recaptcha-disabled" disabled type="submit">{{__('Register')}}</button>
                </div>
                <br>
                <br>
                <br>
            </form>

        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>--}}
<script src="/js/Select2.js"></script>
<script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="/js/intlTelInput.min.js"></script>
<script>

    var imNotARobot = function() {
        $(".recaptcha-disabled").removeAttr('disabled');
    };

    window.start.init({
        Palette: "palette4",
        Mode: "floating right",
        Message: "Diese Website nutzt Cookies, um bestmögliche Funktionalität bieten zu können.  ",
        ButtonText: "Ok",
        LinkText: "Mehr erfahren",
        Location: "https://bicycle.aist.fun/en/privacy",
        Time: "5",
    })</script>
<script>


    // input telephone
    // https://github.com/jackocnr/intl-tel-input#getting-started-using-a-bundler-eg-webpack
    var input = document.querySelector(".tel-input");
    var iti = window.intlTelInput(input, {
        initialCountry: "auto",
        autoPlaceholder: false,
        nationalMode: true,
        separateDialCode: true,
        hiddenInput: "phone",

        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
    });

    window.intlTelInputGlobals.loadUtils("/js/utils.js");

    $('#add_bike_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{route('add_my_bike')}}',
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                window.location.replace("/");
            },
            error: (data) => {
                $('.invalid-feedback').empty();
                $.each(data.responseJSON.errors, (index, value) => {
                    $('.' + index).parent().find('.invalid-feedback').html(value).css('color', 'red');
                });
            },
        });
    });

    $('.heart-icon').on('click', function (e) {
        e.preventDefault();
        let _this = $(this);
        let id = _this.data('bike_id');
        $.ajax({
            type: "post",
            url: '{{ route("toggleFavorite") }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
            },
            success: function (data) {

                if (data != 0) {

                    $('#favorites_count').show();
                    $('#favorites_count').text(data);

                } else {
                    $('#favorites_count').hide();
                }
                _this.toggleClass('active');
            },
        });
    });


    function compare(id) {
        let el = $(event.target);

        $.ajax({
            url: '{{route('compare')}}',
            type: "POST",
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                let count = data.count;
                if (count > 0) {
                    $('.compaireShow').show();
                } else {
                    $('.compaireShow').hide();
                }

                $('#compaire_count').text(data.count);
                @if(Request::is(app()->getLocale()."/compare"))
                window.location.reload();
                @endif
            },
            error: (data) => {
                alert('You cannot add more than two bikes for comparison');
                window.location.reload();
            },
        });
    }


    $('#login_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{route('login')}}',
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                window.location.reload();
            },
            error: (data) => {
                $('.invalid-feedback').empty();
                $.each(data.responseJSON.errors, (index, value) => {
                    $('.login_' + index).parent().find('.invalid-feedback').html(value).css('color', 'red');
                });
            },
        });
    });

    $('#registration_form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize()
        register(formData);
    });



    function register(formData)
    {
        $('#register-modal').addClass('ajax-loader');
        $.ajax({
            url: '{{ route('register') }}',
            type: "POST",
            data: formData,
            success: function (data) {
                window.location.reload();
            },
            error: (data) => {
                $('#register-modal').removeClass('ajax-loader');
                $('.invalid-feedback').empty();
                $.each(data.responseJSON.errors, (index, value) => {
                    if (index == 'phone') {
                        $('.registration_' + index).parent().parent().find('.invalid-feedback').html(value).css('color', 'red');
                    } else {
                        $('.registration_' + index).parent().find('.invalid-feedback').html(value).css('color', 'red');
                    }
                });
            },
        });
    }


    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 5000);

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

    $('.submit_comment_answer_btn').on('click', function (e) {
        e.preventDefault();
        let _this = $(this);
        $.ajax({
            url: '{{ route('reply.comment') }}',
            type: "POST",
            data: _this.parent().serialize(),
            success: function (data) {
                _this.parent().hide();
                _this.parent().prev().append(`<p>${data}</p>`);

            }
        });
    });

    function delete_parent_comment(id) {
        $.ajax({
            url: '{{ route('delete.parent_comment') }}',
            type: "POST",
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }

    function delete_comment(comment_id, answer_id) {

        $.ajax({
            url: '{{ route('delete.comment') }}',
            type: "POST",
            data: {
                'comment_id': comment_id,
                'answer_id': answer_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }

</script>

@yield('scripts')

@if(session()->get('please_verify'))
    <div class="hystmodal login-modal hystmodal--active" id="login-modal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Close</button>

                <h2 class="font-light text-center modal-title">{{__('Please verify your email address')}}</h2>

                <form id="login_form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="text-center">
                        <button type="submit" class="btn btn_green" data-hystclose
                                class="hystmodal__close">{{__('Ok')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @php
        session()->forget('please_verify')
    @endphp
@endif


</body>
</html>
